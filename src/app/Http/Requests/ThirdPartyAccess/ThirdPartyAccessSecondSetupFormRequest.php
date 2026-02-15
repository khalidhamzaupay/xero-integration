<?php

namespace App\Http\Requests\ThirdPartyAccess;


use App\Enums\ThirdPartyAccessStateEnum;
use Illuminate\Foundation\Http\FormRequest as FormRequest;
use Illuminate\Validation\Rules\Enum;

class ThirdPartyAccessSecondSetupFormRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [

            'organization_id' => 'required|exists:third_party_organizations,id|max:255',

        ];

    }


}
