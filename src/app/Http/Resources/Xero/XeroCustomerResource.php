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
        $fields=config('xero.mapping.customers.fields');
        return [
            "Name" => trim($this->{$fields['name']}),
            "FirstName" => $this->{$fields['first_name']},
            "LastName"  => $this->{$fields['last_name']},
            "EmailAddress" => $this->{$fields['email']},

            "ContactStatus" =>XeroContactStatusEnum::ACTIVE->value,
//            "ContactStatus" =>
//                $this->{$fields['status']}=='active'
//                    ? XeroContactStatusEnum::ACTIVE->value
//                    : XeroContactStatusEnum::ARCHIVED->value,

            "Addresses" => [
                [
                    "AddressType" => XeroAddressesEnum::STREET->value,
                    "AddressLine1" => $this->{$fields['address_1']},
                    "City"        => $this->{$fields['city']},
                    "Region"      => $this->{$fields['region']},
                    "Country"     => $this->{$fields['country']},
                    "PostalCode"  => $this->{$fields['postal']},
                ],
            ],

            "Phones" => [
                [
                    "PhoneType" => XeroPhoneTypesEnum::DEFAULT->value,
                    "PhoneNumber" => $this->{$fields['phone']},
                    "PhoneAreaCode" => $this->{$fields['phone_code']},
                ],
            ],

            "Website" => $this->{$fields['website']},
            "Notes"   => $this->{$fields['notes']},

            "IsCustomer" => true,
            "IsSupplier" => false,
        ];
    }
}
