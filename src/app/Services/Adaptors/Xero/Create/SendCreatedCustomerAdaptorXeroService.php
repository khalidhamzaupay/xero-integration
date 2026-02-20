<?php

namespace App\Services\Adaptors\Xero\Create;



use App\Http\Resources\Xero\XeroCustomerResource;
use App\Models\Integrations\Customer;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedCustomerAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Contacts";
    protected $objectName = 'Contacts';
    protected $objectIDName = 'ContactID';
    protected $resourceClass = XeroCustomerResource::class;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Customer::with('xeroMapping', 'user')
            ->whereDoesntHave('xeroMapping', function ($q) {
            })->where(config('xero.mapping.customer.merchant_id'),$merchant_id)

            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
