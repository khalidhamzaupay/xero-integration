<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroInvoiceResource;
use App\Models\Integrations\Invoice;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn('invoices.updated_at', '>', 'third_party_mappings.updated_at');
            })
            ->with(['client.xeroMapping', 'invoiceItems.clinicItem.item', 'invoiceItems.clinicItem.xeroMapping']);

        return $query->orderBy('created_at', 'DESC')->get();
    }
}
