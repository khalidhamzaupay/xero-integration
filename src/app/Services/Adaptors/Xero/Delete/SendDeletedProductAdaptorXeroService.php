<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroProductResource;
use App\Models\Integrations\Product;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendDeletedProductAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Items";
    protected $objectName = 'Items';
    protected $objectIDName = 'ItemID';
    protected $resourceClass = XeroProductResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::DELETE;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $products= Product::where(config('xero.mapping.products.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping')->onlyTrashed();
        if($object_id){
            $products= $products->where(config('xero.mapping.products.fields.id'),$object_id);
        }
        Log::info(" {$products->count()} products to be Deleted" );
        return $products->get();
    }
}
