<?php

namespace App\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use app\Models\Integrations\FailSyncIntegration;
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
