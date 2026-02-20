<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroItemStatusEnum;
use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroProductResource extends JsonResource
{
    public function toArray($request): array
    {
        $data = [
            "Code" => $this->code,
            "Name" => $this->name,
            "Description" => $this->description,

            "SalesDetails" => [
                "UnitPrice"   => (float) $this->sale_price,
                "AccountCode" =>'',
            ],

            "SalesDescription" => $this->description,

            "SalesTaxType" => $this->sale_tax
                ?? XeroTaxTypesEnum::NONE->value,

            "Status" => $this->active
                ? XeroItemStatusEnum::ACTIVE->value
                : XeroItemStatusEnum::ARCHIVED->value,

            "IsSold" => true,
        ];

        // Purchase details (optional in Xero)
        if ($this->cost_price || $this->cost_account) {
            $data["PurchaseDetails"] = [
                "UnitPrice"   => (float) $this->cost_price,
                "AccountCode" => '',
            ];

            $data["PurchaseDescription"] = $this->description;
            $data["PurchaseTaxType"] = $this->purchase_tax
                ?? XeroTaxTypesEnum::NONE->value;
        }

        if ($this->is_inventory) {
            $data["IsTrackedAsInventory"] = true;
            $data["Quantity"] = (float) $this->quantity;
        }

        return $data;
    }
}
