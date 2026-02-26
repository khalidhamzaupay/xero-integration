<?php
namespace App\Services\Adaptors\Xero\Create;

use App\Models\Integrations\Refund;
use App\Models\Integrations\ReturnPayment;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use App\Http\Resources\Xero\XeroReturnPaymentResource;
use Illuminate\Support\Facades\Log;

class SendReturnPaymentAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Payments";
    protected $objectName = 'Payments';
    protected $objectIDName = 'PaymentID';
    protected $resourceClass = XeroReturnPaymentResource::class;

    public function getData($object_id = null): array|\Illuminate\Database\Eloquent\Collection
    {
        $query= ReturnPayment::where(config('xero.mapping.return_payments.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
                ->whereHas('refund')
                ->whereHas('refund.xeroMapping')
                ->whereHas('customer')
                ->whereHas('customer.xeroMapping')
                ->whereDoesntHave('xeroMapping')
                ->with(['refund.xeroMapping','customer.xeroMapping']);
        if($object_id){
                $query= $query->where(config('xero.mapping.return_payments.fields.id'),$object_id);
            }
        Log::info(" {$query->count()} return_payments to be Created" );
        return $query->orderBy(config('xero.mapping.return_payments.fields.created_at'), 'DESC')->get();
    }
}
