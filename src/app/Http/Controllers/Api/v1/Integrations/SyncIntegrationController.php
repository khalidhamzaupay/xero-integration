<?php

namespace app\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use app\Models\Integrations\SyncIntegration;
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
}
