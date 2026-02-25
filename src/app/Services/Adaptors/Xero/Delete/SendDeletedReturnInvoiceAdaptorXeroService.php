<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroReturnInvoiceResource;
use App\Models\Integrations\Refund;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendDeletedReturnInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/CreditNotes";
    protected $objectName = 'CreditNotes';
    protected $objectIDName = 'CreditNoteID';
    protected $resourceClass = XeroReturnInvoiceResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::DELETE;

    public function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {

        $query = Refund::whereHas('xeroMapping')
            ->onlyTrashed();
        if($object_id){
            $query= $query->where(config('xero.mapping.refunds.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} refunds to be Deleted" );

        return $query->get();
    }
}
