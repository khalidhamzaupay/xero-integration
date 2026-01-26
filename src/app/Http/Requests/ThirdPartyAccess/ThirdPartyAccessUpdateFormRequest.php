<?php

namespace App\Http\Requests\ThirdPartyAccess;


class ThirdPartyAccessUpdateFormRequest extends ThirdPartyAccessStoreFormRequest
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
        $parentRules = parent::rules();

        $rules = [
            'sale_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'purchase_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'default_purchase_payment_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'expense_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'default_expense_payment_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'assets_account_id' => 'nullable|string|exists:third_party_chart_of_accounts,id|max:255',
            'organization_id' => 'nullable|string|exists:third_party_organizations,id|max:255',
        ];

        return array_merge($parentRules, $rules);
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return parent::attributes();
    }
}
