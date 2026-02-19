<?php

namespace App\Services\Adaptors\Xero\Create;



use App\Http\Resources\Xero\XeroInvoiceResource;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendCreatedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";  // Xero API endpoint for invoices
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroInvoiceResource::class;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('invoiceItems')
            ->whereHas('client')
            ->whereHas('client.xeroMapping')
            ->whereDoesntHave('xeroMapping')
            ->with(['client.xeroMapping', 'invoiceItems.clinicItem.item', 'invoiceItems.clinicItem.xeroMapping']);

        if ($this->thirdPartyAccess->starts_at) {
            $query->where('date', '>=', $this->thirdPartyAccess->starts_at);
        }

        return $query->orderBy('created_at', 'DESC')->get();
    }
}
