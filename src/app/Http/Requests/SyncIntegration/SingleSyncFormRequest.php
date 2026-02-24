<?php

namespace App\Http\Requests\SyncIntegration;


use App\Enums\IntegrationsType;
use App\Enums\SyncedObjectsEnum;
use App\Enums\ThirdPartySyncProcessTypeEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SingleSyncFormRequest extends FormRequest
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
        $merchantTable = config('xero.mapping.merchants.table', 'users');
        return [
            'merchant_id'       => ['required',"exists:{$merchantTable},id"],
            'object_name'       => ['required',Rule::enum(SyncedObjectsEnum::class)],
            'object_id'         => ['exclude_if:method,' . ThirdPartySyncProcessTypeEnum::DELETE->value,'required'],
            'type'              => ['required', Rule::enum(IntegrationsType::class)],
            'method'            => ['required', Rule::enum(ThirdPartySyncProcessTypeEnum::class)],
        ];

    }
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (! $this->filled(['object_name', 'object_id']) || ($this->input('method') == ThirdPartySyncProcessTypeEnum::DELETE->value)) {
                return;
            }
            $enum = SyncedObjectsEnum::from($this->object_name);
            $modelClass = $enum->model();

            if (! $modelClass::whereKey($this->object_id)->exists()) {
                $validator->errors()->add(
                    'object_id',
                    "Invalid object_id for {$this->object_name}"
                );
            }
        });
    }


}
