<?php


namespace App\Services\Adaptors\Xero\Create;

use App\Http\Resources\Xero\XeroCustomerResource;
use App\Http\Resources\Xero\XeroCreditResource;
use App\Models\Integrations\Credit;
use App\Services\Adaptors\Xero\BaseAdaptorXeroService;
use Illuminate\Support\Facades\Log;

class SendCreatedCreditAdaptorXeroService extends BaseAdaptorXeroService
{

    protected string $endpoint = "https://api.xero.com/api.xro/2.0/BankTransactions";
    protected $objectName = 'BankTransactions';
    protected $objectIDName = 'BankTransactionID';
    protected $resourceClass = XeroCreditResource::class;

    function getData($object_id=null): \Illuminate\Database\Eloquent\Collection|array
    {
        $query = Credit::where(config('xero.mapping.credits.fields.merchant_id'),$this->thirdPartyAccess->merchant_id)
            ->whereDoesntHave('xeroMapping')
            ->whereHas('customer.xeroMapping')
            ->with(['payment', 'customer']);

        if($object_id){
            $query= $query->where(config('xero.mapping.credits.fields.id'),$object_id);
        }
        Log::info(" {$query->count()} credits to be Created" );
        return $query->orderBy(config('xero.mapping.credits.fields.created_at'), 'DESC')->get();
    }
}
