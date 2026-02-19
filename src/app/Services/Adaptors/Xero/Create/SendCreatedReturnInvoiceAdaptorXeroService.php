<?php
namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;

    public function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $clinicId = $this->thirdPartyAccess?->clinic_id;

        $query = ReturnModel::where('clinic_id', $clinicId)
            ->with([
                'xeroMapping',
                'returnItems',
                'invoice.xeroMapping',
                'invoice.client.xeroMapping',
            ])
            ->whereHas('returnItems')
            ->whereHas('invoice.xeroMapping')
            ->whereDoesntHave('xeroMapping');

        if ($this->thirdPartyAccess->starts_at) {
            $query->where('date', '>=', $this->thirdPartyAccess->starts_at);
        }
        return $query->orderBy('created_at', 'DESC')->get();
    }
}
