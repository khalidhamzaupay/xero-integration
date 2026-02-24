<?php


namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroCustomerPaymentResource;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendCreatedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroCustomerPaymentResource::class;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = CustomerPayment::where(config('xero.mapping.customer_payments.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereDoesntHave('xeroMapping')
            ->whereHas('invoice.xeroMapping')
            ->with(['invoice','invoice.xeroMapping','payment.paymentMethod']);
        if($object_id){
            $query= $query->where(config('xero.mapping.customer_payments.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} customer_payments to be Created" );
        return $query->orderBy(config('xero.mapping.customer_payments.fields.created_at'), 'DESC')->get();
    }
}
