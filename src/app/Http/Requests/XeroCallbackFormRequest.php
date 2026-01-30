<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest as FormRequest;

class XeroCallbackFormRequest extends FormRequest
{
    /**
     * Determine if the ThirdPartyAccess is authorized to make this request.
     *
     * @return bool
     */
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
            'code' => 'required|string',
            'state' => 'required|string|max:255',
        ];
    }


}
