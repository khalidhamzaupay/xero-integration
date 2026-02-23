<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroItemStatusEnum;
use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $fields=config('xero.mapping.products.fields');
        $data = [
            "Code" => $this->{$fields['code']},
            "Name" => $this->{$fields['name']},
            "Description" => $this->{$fields['description']},

            "SalesDetails" => [
                "UnitPrice"   => (float) $this->{$fields['sale_price']},
                "AccountCode" =>$this->merchant?->xeroThirdPartyAccess?->saleAccount?->mapping_id,
            ],

            "SalesDescription" => $this->{$fields['description']},

            "SalesTaxType" => $this->{$fields['sale_tax']}
                ?? XeroTaxTypesEnum::NONE->value,
            "Status" => XeroItemStatusEnum::ACTIVE->value,
//            "Status" => $this->{$fields['status']}=='active'
//                ? XeroItemStatusEnum::ACTIVE->value
//                : XeroItemStatusEnum::ARCHIVED->value,

            "IsSold" => true,
        ];

        // Purchase details (optional in Xero)
        if ($this->{$fields['cost_price']} || $this->{$fields['cost_account']}) {
            $data["PurchaseDetails"] = [
                "UnitPrice"   => (float) $this->{$fields['cost_price']},
                "AccountCode" => $this->merchant?->xeroThirdPartyAccess?->purchaseAccount?->mapping_id,
            ];

            $data["PurchaseDescription"] = $this->{$fields['description']};
            $data["PurchaseTaxType"] = $this->{$fields['purchase_tax']}
                ?? XeroTaxTypesEnum::NONE->value;
        }

        if ($this->{$fields['is_inventory']}) {
            $data["IsTrackedAsInventory"] = true;
            $data["Quantity"] = (float) $this->{$fields['quantity']};
        }

        return $data;
    }
}
