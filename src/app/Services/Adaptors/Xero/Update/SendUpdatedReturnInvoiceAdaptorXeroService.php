<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendUpdatedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;


    public function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Refund::whereHas('xeroMapping', function ($q) {
                $q->whereColumn(config('xero.mapping.refunds.table').'.'.config('xero.mapping.refunds.fields.updated_at'), '>', 'third_party_mappings.updated_at');
            })
            ->with(['invoice.xeroMapping', 'items.product', 'items.product.xeroMapping']);

        if($object_id){
            $query= $query->where(config('xero.mapping.refunds.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} refunds to be Updated" );
        return $query->orderBy(config('xero.mapping.refunds.fields.created_at'), 'DESC')->get();
    }
}
