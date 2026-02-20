<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroCustomerPaymentResource;
use App\Models\Integrations\CustomerPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedCustomerPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroCustomerPaymentResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = CustomerPayment::query()
            ->whereHas('payment', function ($q) {
                $q->where('clinic_id', $this->thirdPartyAccess?->clinic_id);
            })
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn('payment_invoices.updated_at', '>', 'third_party_mappings.updated_at');
            })
            ->with(['payment', 'invoice', 'payment.paymentMethod', 'payment.client.xeroMapping', 'invoice.xeroMapping', 'payment.paymentMethod']);


        return $query->orderBy('created_at', 'DESC')->get();
    }
}
