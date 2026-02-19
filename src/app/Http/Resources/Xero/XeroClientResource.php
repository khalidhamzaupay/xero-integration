<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAddressesEnum;
use App\Enums\Xero\XeroContactStatusEnum;
use App\Enums\Xero\XeroPhoneTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroClientResource extends JsonResource
{

    public function toArray($request): array
    {
        $data = [
            "Name" => "",
            "FirstName" => "",
            "LastName"  => "",
            "EmailAddress" => "",
            "ContactStatus" => $this->status == 'active' ? XeroContactStatusEnum::ACTIVE->value : XeroContactStatusEnum::ARCHIVED->value,
            "Addresses" => [
                [
                    "AddressType" => XeroAddressesEnum::POBOX->value,
                    "AddressLine1" => "",
                    "City"        => "",
                    "Region"      => "",
                    "Country"     => "",
                    "PostalCode"  => "",
                ],
                [
                    "AddressType" => XeroAddressesEnum::STREET->value,
                    "AddressLine1" => "",
                    "City"        => "",
                    "Region"      => "",
                    "Country"     => "",
                    "PostalCode"  => "",
                ]
            ],
            "Phones" => [
                [
                    "PhoneType" => XeroPhoneTypesEnum::DEFAULT->value,
                    "PhoneNumber" => "",
                    "PhoneAreaCode" => "",
                ],
                [
                    "PhoneType" => XeroPhoneTypesEnum::FAX->value,
                    "PhoneNumber" => "",
                    "PhoneAreaCode" => "",
                ]
            ],
            "Website" => "",
            "Notes"   => "",
            "IsCustomer" => true,
            "IsSupplier" => false,
        ];

        return $data;
    }
}
