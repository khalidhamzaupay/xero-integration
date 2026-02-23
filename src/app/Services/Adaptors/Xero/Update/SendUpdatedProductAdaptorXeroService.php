<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroProductResource;
use App\Models\Integrations\Product;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendUpdatedProductAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Items";
    protected $objectName = 'Items';
    protected $objectIDName = 'ItemID';
    protected $resourceClass = XeroProductResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $products= Product::where(config('xero.mapping.products.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn(config('xero.mapping.products.table').'.'.config('xero.mapping.products.fields.updated_at'), '>', 'third_party_mappings.updated_at');
            });
        if($object_id){
            $products= $products->where(config('xero.mapping.products.fields.id'),$object_id);
        }
        $products =$products->orderBy(config('xero.mapping.products.fields.created_at'), 'DESC')->get();
        Log::info(" {$products->count()} products to be updated" );
        return $products;
    }
}
