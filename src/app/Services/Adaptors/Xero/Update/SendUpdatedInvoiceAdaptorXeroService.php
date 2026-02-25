<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroInvoiceResource;
use App\Models\Integrations\Invoice;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendUpdatedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where(config('xero.mapping.invoices.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn(config('xero.mapping.invoices.table').'.'.config('xero.mapping.invoices.fields.updated_at'), '>', 'third_party_mappings.updated_at');
            })
            ->with(['client.xeroMapping', 'items.product', 'items.product.xeroMapping']);
        if($object_id){
            $query= $query->where(config('xero.mapping.invoices.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} invoices to be Updated" );
        return $query->orderBy(config('xero.mapping.invoices.fields.created_at'), 'DESC')->get();
    }
}
