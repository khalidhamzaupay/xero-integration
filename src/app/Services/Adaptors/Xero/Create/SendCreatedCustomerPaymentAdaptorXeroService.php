<?php


namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroCustomerPaymentResource;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroCustomerPaymentResource::class;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = PaymentInvoice::query()
            ->whereHas('payment', function ($q) {
                $q->where('clinic_id', $this->thirdPartyAccess?->clinic_id)
                    ->where('flow', PaymentFlowEnum::INCOME->value)
                    ->whereHas('client.xeroMapping');
            })
            ->whereDoesntHave('xeroMapping')
            ->whereHas('invoice.xeroMapping')
            ->with(['payment','invoice','payment.paymentMethod','payment.client.xeroMapping','invoice.xeroMapping','payment.paymentMethod']);

        if ($this->thirdPartyAccess->starts_at) {
            $query->where('payment_date', '>=', $this->thirdPartyAccess->starts_at);
        }
        return $query->orderBy('created_at', 'DESC')->get();
    }
}
