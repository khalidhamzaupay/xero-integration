<?php

use App\Http\Controllers\Api\v1\Integrations\IntegrationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Integrations\ThirdPartyAccessController;
use App\Http\Controllers\Api\v1\Integrations\ThirdPartyOrganizationController;
use App\Http\Controllers\Api\v1\Integrations\SyncIntegrationController;
//Route::group([ 'middleware' => 'auth:sanctum' ], function() {

    Route::resource('third-party-accesses', ThirdPartyAccessController::class)->only(['store','update','destroy']);
    Route::post('third-party-accesses/second-setup/{id}', [ThirdPartyAccessController::class,'secondTimeSetup']);
    Route::resource('third-party-organizations', ThirdPartyOrganizationController::class);
    Route::get('get-payment-methods-for-mapping/{id}/{type}',[IntegrationController::class,'getMerchantIntegrationPaymentMethodConfigurations']);
    Route::post('payment-methods-mapping/{id}/{type}',[IntegrationController::class,'storePaymentTypeMappingForIntegration']);
    Route::post('sync-third-party-integration',[SyncIntegrationController::class,'sync']);
//});
