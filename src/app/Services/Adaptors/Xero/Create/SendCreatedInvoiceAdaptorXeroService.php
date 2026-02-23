<?php

namespace App\Services\Adaptors\Xero\Create;



use App\Http\Resources\Xero\XeroInvoiceResource;
use App\Models\Integrations\Invoice;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendCreatedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";  // Xero API endpoint for invoices
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroInvoiceResource::class;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where(config('xero.mapping.invoices.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('items')
            ->whereHas('client')
            ->whereHas('client.xeroMapping')
            ->whereDoesntHave('xeroMapping')
            ->with(['client.xeroMapping', 'items.product', 'items.product.xeroMapping']);
        if($object_id){
            $query= $query->where(config('xero.mapping.invoices.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} invoices to be Created" );
        return $query->orderBy(config('xero.mapping.invoices.fields.created_at'), 'DESC')->get();
    }
}
