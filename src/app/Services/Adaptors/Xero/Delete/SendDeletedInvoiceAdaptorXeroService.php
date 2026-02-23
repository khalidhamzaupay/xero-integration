<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroVoidResource;
use App\Models\Integrations\Invoice;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendDeletedInvoiceAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/Invoices";
    protected $objectName = 'Invoices';
    protected $objectIDName = 'InvoiceID';
    protected $resourceClass = XeroVoidResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID; //making the status voided because there's no delete option

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Invoice::where(config('xero.mapping.invoices.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping')
            ->onlyTrashed();
        if($object_id){
            $query= $query->where(config('xero.mapping.invoices.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} invoices to be Deleted" );

        return $query->get();
    }
}
