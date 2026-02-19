<?php

namespace App\Http\Requests\SyncIntegration;


use App\Enums\IntegrationsType;
use Illuminate\Foundation\Http\FormRequest;

class SyncIntegrationFormRequest extends FormRequest
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
            'third_parts_access_id'     => 'required|exists:third_party_accesses,id',
        ];

    }


}
