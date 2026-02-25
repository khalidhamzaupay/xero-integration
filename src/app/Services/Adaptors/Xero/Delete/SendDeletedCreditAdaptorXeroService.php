<?php

namespace App\Services\Adaptors\Xero\Delete;

use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Resources\Xero\XeroDeleteCreditResource;
use App\Models\Integrations\Credit;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendDeletedCreditAdaptorXeroService extends BaseAdaptorXeroService
{
    protected string $endpoint = "https://api.xero.com/api.xro/2.0/BankTransactions";
    protected $objectName = 'BankTransactions';
    protected $objectIDName = 'BankTransactionID';
    protected $resourceClass = XeroDeleteCreditResource::class;
    protected $syncType = ThirdPartySyncProcessTypeEnum::VOID;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Credit::where(config('xero.mapping.credits.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereHas('xeroMapping')
            ->onlyTrashed();
        if($object_id){
            $query= $query->where(config('xero.mapping.credits.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} credits to be Deleted" );
        return $query->get();
    }
}
