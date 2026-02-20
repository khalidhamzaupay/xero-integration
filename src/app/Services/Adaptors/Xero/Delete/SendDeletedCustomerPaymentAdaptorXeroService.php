<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroVoidResource;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendDeletedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroVoidResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = CustomerPayment::query()
            ->whereHas('payment', function ($q) {
                $q->where('clinic_id', $this->thirdPartyAccess?->clinic_id);
            })
            ->whereHas('xeroMapping')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->get();

        return $query;
    }
}
