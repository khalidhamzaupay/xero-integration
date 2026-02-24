<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Enums\SyncedObjectsEnum;
use App\Enums\SyncIntegrationStatusEnum;
use App\Enums\ThirdPartySyncProcessTypeEnum;
use App\Http\Controllers\ApplicationController;
use App\Http\Requests\SyncIntegration\SingleSyncFormRequest;
use App\Http\Requests\SyncIntegration\SyncIntegrationFormRequest;
use App\Http\Resources\SyncIntegration\SyncIntegrationResource;
use App\Models\Integrations\SyncIntegration;
use App\Models\Integrations\ThirdPartyAccess;
use App\Services\SyncIntegration\IntegrationExportDataService;
use App\Traits\Responder;
use Illuminate\Http\Request;

class SyncIntegrationController extends ApplicationController
{
    use Responder;
    protected $viewPath = 'SyncIntegration';
    protected $resourceRoute = 'SyncIntegration';
    protected $moduleAlias = 'Integrations';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SyncIntegration $syncIntegration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SyncIntegration $syncIntegration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SyncIntegration $syncIntegration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SyncIntegration $syncIntegration)
    {
        //
    }
    public function sync(SyncIntegrationFormRequest $request)
    {
        $data = $request->validated();
        $syncIntegrationsService = new IntegrationExportDataService($data['third_party_access_id']);
        $syncIntegrations = $syncIntegrationsService->export();
        if ($syncIntegrations) {
            $prams = [
                "data" => [
                    "title" => 'show-all Sync Integration', "alias" => $this->moduleAlias,
                    "syncIntegrations" => SyncIntegrationResource::collection($syncIntegrations)
                ],
                "redirectTo" => ["route" => "{$this->resourceRoute}.index"]
            ];

        } else {

            $prams = [
                "data" => ["message" => "Create failed"],
                "response_code" => 422,
                "redirectBack" => true
            ];

        }
        return $this->response($prams);
    }


    public function singleSync(SingleSyncFormRequest $request)
    {
        $type = $request->get('type');
        $processEnum = ThirdPartySyncProcessTypeEnum::from(
            (int) $request->get('method')
        );
        $method = strtolower($processEnum->getLabel());
        $object = $request->get('object_name');
        $model = SyncedObjectsEnum::from($object)->model();
        $thirdPartyAccess = ThirdPartyAccess::where('type',$type)
            ->where('merchant_id',$request->get('merchant_id'))
            ->first();
        $syncIntegration = SyncIntegration::create(['merchant_id' => $thirdPartyAccess->merchant_id, 'method' => $method, 'type' => $type]);
        $adaptorClass=config('singleSyncAdaptor.'.$type.'.'.$object.'.'.$method);
        try{
            (new $adaptorClass($thirdPartyAccess,$syncIntegration?->id))->export($request['object_id']);
            $syncIntegration->update(['end_at' => now(), 'status' => SyncIntegrationStatusEnum::SUCCESS->value]);
            if($model::find($request->get('object_id'))?->xeroMapping)
                $message="the object has been synced successfully";
            else
                $message="cannot sync this object. please check the error returns from Xero";
            $prams = [
                "data" => ["message" => $message],
                "redirectTo" => ["route" => "{$this->resourceRoute}.index"]
            ];
        }catch (\Exception $e){
            $syncIntegration->update(['end_at' => now(), 'status' => SyncIntegrationStatusEnum::FAIL->value]);
            $prams = [
                "data" => ["message" => "sync has been failed"],
                "response_code" => 422,
                "redirectBack" => true
            ];
        }
        return $this->response($prams);
    }
}
