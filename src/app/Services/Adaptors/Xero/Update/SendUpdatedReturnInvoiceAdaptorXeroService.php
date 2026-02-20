<?php
namespace App\Services\Adaptors\Xero\Update;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;

class SendUpdatedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::UPDATE;


    public function getData(): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Refund::where('clinic_id', $this->thirdPartyAccess?->clinic_id)
            ->with([
                'xeroMapping',
                'returnItems',
                'invoice.xeroMapping',
                'invoice.client.xeroMapping',
            ])
            ->whereHas('xeroMapping', function ($q) {
                $q->whereColumn('returns.updated_at', '>', 'third_party_mappings.updated_at');
            })
            ->with(['xeroMapping', 'payment', 'client']);

        return $query->orderBy('created_at', 'DESC')->get();
    }
}
