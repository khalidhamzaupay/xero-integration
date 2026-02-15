<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Integrations\ThirdPartyAccessController;
use App\Http\Controllers\Api\v1\Integrations\ThirdPartyOrganizationController;
//Route::group([ 'middleware' => 'auth:sanctum' ], function() {

    Route::resource('third-party-accesses', ThirdPartyAccessController::class)->only(['store','update','destroy']);
    Route::post('third-party-accesses/second-setup/{id}', [ThirdPartyAccessController::class,'secondTimeSetup']);
    Route::resource('third-party-organizations', ThirdPartyOrganizationController::class);

//});
