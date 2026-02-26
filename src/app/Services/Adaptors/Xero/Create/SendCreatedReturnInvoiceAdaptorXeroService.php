<?php
namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendCreatedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;

    public function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Refund::where(config('xero.mapping.refunds.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('items')
            ->whereHas('invoice')
            ->whereHas('invoice.xeroMapping')
            ->whereDoesntHave('xeroMapping')
            ->with(['invoice.xeroMapping','invoice.client.xeroMapping', 'items.product', 'items.product.xeroMapping']);

        if($object_id){
            $query= $query->where(config('xero.mapping.refunds.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} refunds to be Created" );
        return $query->orderBy(config('xero.mapping.refunds.fields.created_at'), 'DESC')->get();
    }
}
