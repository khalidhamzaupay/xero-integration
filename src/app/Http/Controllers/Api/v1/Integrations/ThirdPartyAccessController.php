<?php

namespace app\Http\Controllers\Api\v1\Integrations;

use App\Http\Controllers\ApplicationController;
use app\Models\Integrations\ThirdPartyAccess;
use Illuminate\Http\Request;

class ThirdPartyAccessController extends ApplicationController
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
    public function show(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ThirdPartyAccess $thirdPartyAccess)
    {
        //
    }
}
