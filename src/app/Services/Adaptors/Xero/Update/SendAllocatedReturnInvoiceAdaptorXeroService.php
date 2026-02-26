<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroReturnInvoiceAllocationResource;
use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendAllocatedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected string $endpoint_ext = 'Allocations';
    protected $objectName = 'Allocations';
    protected $objectIDName = 'CreditNoteID';
    protected string $tag = 'Allocated';
    protected $resourceClass = XeroReturnInvoiceAllocationResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;


    public function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Refund::where(config('xero.mapping.credits.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping', function ($q) {
            $q->where(function($sub) {
                $sub->where('third_party_tag', '!=', $this->tag)
                    ->orWhereNull('third_party_tag');
                });
            })
            ->with(['invoice.xeroMapping', 'items.product', 'items.product.xeroMapping']);
        if($object_id){
            $query= $query->where(config('xero.mapping.refunds.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} refunds to be Allocated" );
        return $query->orderBy(config('xero.mapping.refunds.fields.created_at'), 'DESC')->get();
    }
}
