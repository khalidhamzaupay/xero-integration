<?php

namespace App\Http\Requests\Configrations;


use Illuminate\Foundation\Http\FormRequest;

class MapPaymentMethodForThirdPartyAccessFormRequest extends FormRequest
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
            '*.object_id' => 'required|string|exists:payment_methods,id|max:255',
            '*.third_party_id' => 'required|string|exists:third_party_chart_of_accounts,mapping_id|max:255',
        ];

    }


}
