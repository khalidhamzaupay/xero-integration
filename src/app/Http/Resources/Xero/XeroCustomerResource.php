<?php

namespace App\Http\Resources\Xero;

use App\Enums\Xero\XeroAddressesEnum;
use App\Enums\Xero\XeroContactStatusEnum;
use App\Enums\Xero\XeroPhoneTypesEnum;
use Illuminate\Http\Resources\Json\JsonResource;

class XeroCustomerResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            "Name" => trim($this->name),
            "FirstName" => $this->first_name,
            "LastName"  => $this->last_name,
            "EmailAddress" => $this->email,

            "ContactStatus" =>
                $this->active
                    ? XeroContactStatusEnum::ACTIVE->value
                    : XeroContactStatusEnum::ARCHIVED->value,

            "Addresses" => [
                [
                    "AddressType" => XeroAddressesEnum::STREET->value,
                    "AddressLine1" => $this->address_1,
                    "City"        => $this->city,
                    "Region"      => $this->region,
                    "Country"     => $this->country,
                    "PostalCode"  => $this->postal,
                ],
            ],

            "Phones" => [
                [
                    "PhoneType" => XeroPhoneTypesEnum::DEFAULT->value,
                    "PhoneNumber" => $this->phone,
                    "PhoneAreaCode" => $this->phone_code,
                ],
            ],

            "Website" => $this->website,
            "Notes"   => $this->notes,

            "IsCustomer" => true,
            "IsSupplier" => false,
        ];
    }
}
