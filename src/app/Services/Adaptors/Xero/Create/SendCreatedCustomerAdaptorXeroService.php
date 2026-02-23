<?php

namespace App\Services\Adaptors\Xero\Create;



use App\Http\Resources\Xero\XeroCustomerResource;
use App\Models\Integrations\Customer;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendCreatedCustomerAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Contacts";
    protected $objectName = 'Contacts';
    protected $objectIDName = 'ContactID';
    protected $resourceClass = XeroCustomerResource::class;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $customers=Customer::with('xeroMapping')
            ->whereDoesntHave('xeroMapping')
            ->where(config('xero.mapping.customers.fields.merchant_id'),$this->thirdPartyAccess->merchant_id);
        if($object_id){
            $customers= $customers->where(config('xero.mapping.customers.fields.id'),$object_id);
        }
        $customers= $customers->orderBy(config('xero.mapping.customers.fields.created_at'), 'DESC')->get();
        Log::info(" {$customers->count()} customers to be created" );
        return $customers;
    }
}
