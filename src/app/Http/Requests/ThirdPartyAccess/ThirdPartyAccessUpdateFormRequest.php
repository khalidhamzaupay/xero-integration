<?php

namespace App\Http\Requests\ThirdPartyAccess;


use App\Enums\ThirdPartyAccessStateEnum;
use Illuminate\Foundation\Http\FormRequest as FormRequest;
use Illuminate\Validation\Rules\Enum;

class ThirdPartyAccessUpdateFormRequest extends FormRequest
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
            'sale_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'purchase_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'default_purchase_payment_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'expense_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'default_expense_payment_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'assets_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'organization_id' => 'nullable|string|exists:third_party_organizations,id|max:255',
            'state' => ['nullable', new Enum(ThirdPartyAccessStateEnum::class)],
            'expires_at'    => 'nullable|date',

        ];

    }


}
