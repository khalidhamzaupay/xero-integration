<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('integrations/xero/callback', [\App\Http\Controllers\Api\v1\Integrations\IntegrationController::class, 'xeroHandleCallback'])->name('xero.callback');
