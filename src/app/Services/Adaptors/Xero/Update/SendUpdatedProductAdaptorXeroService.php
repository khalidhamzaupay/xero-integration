<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroProductResource;
use App\Models\Integrations\Product;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedProductAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Items";
    protected $objectName = 'Items';
    protected $objectIDName = 'ItemID';
    protected $resourceClass = XeroProductResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $clinicId = $this->thirdPartyAccess?->clinic_id;

        return Product::with('item', 'item.unit', 'item.category')
            ->where('clinic_id', $clinicId)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn('clinic_items.updated_at', '>', 'third_party_mappings.updated_at');
            })
            ->orderBy('updated_at', 'DESC')
            ->get();
    }
}
