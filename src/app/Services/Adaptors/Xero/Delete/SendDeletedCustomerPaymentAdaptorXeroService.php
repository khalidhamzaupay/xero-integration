<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroDeleteResource;
use App\Http\Resources\Xero\XeroVoidResource;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendDeletedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroDeleteResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = CustomerPayment::where(config('xero.mapping.customer_payments.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping')
            ->onlyTrashed();
        if($object_id){
            $query= $query->where(config('xero.mapping.customer_payments.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} customer_payments to be Deleted" );
        return $query->get();

    }
}
