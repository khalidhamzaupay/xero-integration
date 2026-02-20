<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroVoidResource;
use App\Models\Integrations\Credit;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendDeletedCreditAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroVoidResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Credit::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('xeroMapping')
            ->onlyTrashed()
            ->orderBy('deleted_at', 'DESC')
            ->get();
        return $query;
    }
}
