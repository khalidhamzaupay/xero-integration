<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroCustomerPaymentResource;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendUpdatedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroCustomerPaymentResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {

        $query = CustomerPayment::where(config('xero.mapping.customer_payments.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn(config('xero.mapping.customer_payments.table').'.'.config('xero.mapping.customer_payments.fields.updated_at'), '>', 'third_party_mappings.updated_at');
            })
            ->with(['invoice','invoice.xeroMapping','payment.paymentMethod']);
        if($object_id){
            $query= $query->where(config('xero.mapping.customer_payments.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} customer_payments to be Updated" );
        return $query->orderBy(config('xero.mapping.customer_payments.fields.created_at'), 'DESC')->get();
    }
}
