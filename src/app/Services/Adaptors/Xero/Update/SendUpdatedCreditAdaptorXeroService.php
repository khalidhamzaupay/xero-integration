<?php

namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroCreditResource;
use App\Models\Integrations\Credit;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedCreditAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroCreditResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;

    function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Credit::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn('credits.updated_at', '>', 'third_party_mappings.updated_at');
            })
            ->with(['xeroMapping', 'payment', 'client']);

        return $query->orderBy('created_at', 'DESC')->get();
    }
}
