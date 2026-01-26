<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\Integrations\ThirdPartyAccessController;
Route::group([ 'middleware' => 'auth:api' ], function() {

    Route::resource('/third-party-accesses', ThirdPartyAccessController::class)->only(['store','update','destroy']);

});
