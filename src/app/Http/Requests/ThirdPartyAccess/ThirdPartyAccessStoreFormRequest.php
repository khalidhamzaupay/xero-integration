<?php

namespace App\Http\Requests\ThirdPartyAccess;

use App\Enums\IntegrationsType;
use Illuminate\Foundation\Http\FormRequest as FormRequest;
use Illuminate\Validation\Rule;

class ThirdPartyAccessStoreFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        return [
                   'type'          => 'required|string|max:255',
                   'access_token'  => 'nullable|string|max:255',
                   'access_key' => 'nullable|string|max:255',
                   'client_id' => [
                       'nullable', 'string','max:255',
                       Rule::requiredIf(fn() => in_array($this->type,
                           [
                               IntegrationsType::Xero->value,
                           ])),
                   ],
                   'client_secret' => [
                       'nullable','string','max:255',
                       Rule::requiredIf(fn() => in_array($this->type,
                           [
                               IntegrationsType::Xero->value,
                           ])),
                       'string',
                       'max:255',
                   ],
                   'expires_at'    => 'nullable|date',
                   'merchant_id'     => 'required|string',
               ];
    }
}
