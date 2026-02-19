<?php


namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroClientResource;
use App\Http\Resources\Xero\XeroCreditResource;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedCreditAdaptorXeroService extends BaseAdaptorXeroService
{

    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroCreditResource::class;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Credit::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->where('type', '!=', 'Refund')
            ->with(['xeroMapping', 'payment', 'client'])
            ->whereHas('client.xeroMapping')
            ->whereDoesntHave('xeroMapping');

        if ($this->thirdPartyAccess->starts_at) {
            $query->where('payment_date', '>=', $this->thirdPartyAccess->starts_at);
        }

        return $query->orderBy('created_at', 'DESC')->get();
    }
}
