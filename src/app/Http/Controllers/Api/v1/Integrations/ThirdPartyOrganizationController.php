<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use App\Http\Resources\ThirdPartyOrganization\ThirdPartyMappingResource;
use App\Models\Integrations\ThirdPartyOrganization;
use App\Traits\Responder;
use Illuminate\Http\Request;

class ThirdPartyOrganizationController extends ApplicationController
{
    use Responder;
    protected $viewPath = 'ThirdPartyOrganization';
    protected $resourceRoute = 'ThirdPartyOrganization';
    protected $moduleAlias = 'Integrations';
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = ThirdPartyOrganization::query();
            if ($request->filled('type')) {
                $query->where('type', $request->type);
            }

            $index = $query->get();
            $params = [
                "data" => [
                    "title"            => 'show-all organizations',
                    "alias"            => $this->moduleAlias,
                    "organizations" => ThirdPartyMappingResource::collection($index)
                ],
                "view" => "{$this->moduleAlias}::{$this->viewPath}.index"
            ];
        } catch (\Exception $exception) {
            $params = [
                "data" => ["message" => "Something went wrong: " . $exception->getMessage()],
                "response_code" => 422,
                "redirectBack" => true
            ];
            return $this->response($params);
        }
        return $this->response($params);
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
    public function show(ThirdPartyOrganization $thirdPartyMapping)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThirdPartyOrganization $thirdPartyMapping)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThirdPartyOrganization $thirdPartyMapping)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThirdPartyOrganization $thirdPartyMapping)
    {
        //
    }
}
