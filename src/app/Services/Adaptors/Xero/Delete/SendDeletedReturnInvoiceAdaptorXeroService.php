<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendDeletedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::DELETE;

    public function getData(): \Illuminate\Database\Eloquent\Collection|array
    {

        return Refund::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('xeroMapping')
            ->orderBy('deleted_at', 'DESC')
            ->onlyTrashed()
            ->get();

    }
}
