<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use App\Http\Resources\ThirdPartyIntegrationFails\ThirdPartyIntegrationFailsResource;
use App\Models\Integrations\FailSyncIntegration;
use Illuminate\Http\Request;

class FailSyncIntegrationController extends ApplicationController
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $merchant_id)
    {
        $query = FailSyncIntegration::where('merchant_id', $merchant_id)
            ->with(['object', 'syncIntegration']);

        foreach (FailSyncIntegration::$allowedFilersExact as $filter) {
            if ($request->has($filter)) {
                $query->where($filter, $request->get($filter));
            }
        }

        if ($request->has('message')) {
            $query->where('message', 'LIKE', '%' . $request->get('message') . '%');
        }

        foreach (FailSyncIntegration::$allowedFilters as $filter) {
            if ($request->has($filter)) {
                $query->where($filter, 'LIKE', '%' . $request->get($filter) . '%');
            }
        }

        $sortField = $request->get('sort', 'created_at');
        $direction = $request->get('direction', 'desc');

        if (in_array($sortField, FailSyncIntegration::$allowedSorts)) {
            $query->orderBy($sortField, $direction);
        }

        $perPage = $request->get('per_page', 15);
        return ThirdPartyIntegrationFailsResource::collection($query->paginate($perPage));
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
    public function show(FailSyncIntegration $failSyncIntegration)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(FailSyncIntegration $failSyncIntegration)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, FailSyncIntegration $failSyncIntegration)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(FailSyncIntegration $failSyncIntegration)
    {
        //
    }
}
