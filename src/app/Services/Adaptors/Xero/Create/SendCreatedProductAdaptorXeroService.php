<?php

namespace App\Services\Adaptors\Xero\Create;



use App\Http\Resources\Xero\XeroProductResource;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedProductAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Items";
    protected $objectName = 'Items';
    protected $objectIDName = 'ItemID';
    protected $resourceClass = XeroProductResource::class;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Product::with('item', 'item.unit', 'item.category')
            ->where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereDoesntHave('xeroMapping')
            ->orderBy('created_at', 'DESC')
            ->get();
    }
}
