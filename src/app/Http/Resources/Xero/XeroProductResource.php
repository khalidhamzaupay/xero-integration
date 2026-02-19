<?php

namespace App\Http\Resources\Xero;


use App\Enums\Xero\XeroItemStatusEnum;
use App\Enums\Xero\XeroTaxTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroProductResource extends JsonResource
{
    public function toArray($request): array
    {

        $base = [
            "Code"   => "",
            "Name"   => "",
            "Description" => "",
            "SalesDetails" => [
                "UnitPrice"   => "",
                "AccountCode" => "",
            ],
            "PurchaseDescription" => "",
            "SalesDescription"    => "",
            "PurchaseTaxType"     => XeroTaxTypesEnum::NONE->value,
            "SalesTaxType"        => XeroTaxTypesEnum::NONE->value,
            "Status"              => XeroItemStatusEnum::ACTIVE->value,
            "IsSold"              => true,
            "IsTrackedAsInventory" => "",
            "Quantity" => ""
        ];

        $base["PurchaseDetails"] = [
            "UnitPrice"   => "",
            "AccountCode" => "",
        ];

        return $base;
    }
}

