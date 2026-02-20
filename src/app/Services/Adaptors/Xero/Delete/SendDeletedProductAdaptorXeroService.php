<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroProductResource;
use App\Models\Integrations\Product;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendDeletedProductAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Items";
    protected $objectName = 'Items';
    protected $objectIDName = 'ItemID';
    protected $resourceClass = XeroProductResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::DELETE;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $clinicId = $this->thirdPartyAccess?->clinic_id;

        return Product::where('clinic_id', $clinicId)
            ->whereHas('xeroMapping')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->get();
//        dd($c);
    }
}
