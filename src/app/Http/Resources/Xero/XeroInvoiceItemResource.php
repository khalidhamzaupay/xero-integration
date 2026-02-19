<?php


namespace App\Http\Resources\Xero;


use Illuminate\Http\Resources\Json\JsonResource;

class XeroInvoiceItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $itemNameWithNoSPCharacters = "";
        $data = [
            "ItemCode" => "",
            "Description" => "",
            "Quantity" => "",
            "UnitAmount" => "",
            "AccountCode" => $this->invoice->clinic?->xeroThirdPartyAccess?->saleAccount?->mapping_id,
            "TaxType" => $this->taxGroup?->xeroMapping($this->invoice?->merchant_id)?->first()?->third_party_id ,//'OUTPUT',
            "TaxAmount" => "",
            "DiscountRate" => "",
        ];



        return $data;
    }
}

