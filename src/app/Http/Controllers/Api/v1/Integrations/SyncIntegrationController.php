<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Factories\DataExportToThirdPartyFactory;
use App\Http\Controllers\ApplicationController;
use App\Http\Requests\SyncIntegration\SyncIntegrationFormRequest;
use app\Models\Integrations\SyncIntegration;
use App\Services\SyncIntegration\IntegrationExportDataService;
use Illuminate\Http\Request;

class SyncIntegrationController extends ApplicationController
{
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
        $syncIntegrationsService = new IntegrationExportDataService($data['third_parts_access_id']);
        $syncIntegrations = $syncIntegrationsService->export();
        if ($syncIntegrations) {
            $prams = [
                "data" => [
                    "title" => __('main.show-all') . ' ' . __('main.SyncIntegration'), "alias" => $this->moduleAlias,
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
}
