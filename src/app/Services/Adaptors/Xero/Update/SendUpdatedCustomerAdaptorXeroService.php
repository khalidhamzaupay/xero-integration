<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroCustomerResource;
use App\Models\Integrations\Customer;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedCustomerAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Contacts";
    protected $objectName = 'Contacts';
    protected $objectIDName = 'ContactID';
    protected $resourceClass = XeroCustomerResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        if($object_id){
            $customers= Customer::with('xeroMapping')
                ->where('id',$object_id)
                ->get();
        }else{
            $customers=Customer::with('xeroMapping')
                ->whereHas('xeroMapping', function ($q) {
                    $q->whereColumn(config('xero.mapping.customers.table').'.updated_at', '>', 'third_party_mappings.updated_at');
                })
                ->where(config('xero.mapping.customers.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
                ->orderBy('created_at', 'DESC')
                ->get();
        }
        return $customers;

    }
}
