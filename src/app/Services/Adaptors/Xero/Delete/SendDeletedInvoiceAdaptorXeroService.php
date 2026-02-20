<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroVoidResource;
use App\Models\Integrations\Invoice;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendDeletedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroVoidResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID; //making the status voided because there's no delete option

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('xeroMapping')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->get();
        return $query;
    }
}
