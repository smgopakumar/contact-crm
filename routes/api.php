<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\ContactController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/leads', [LeadController::class, 'store']);
Route::post('/accounts', [AccountController::class, 'store']);

// Route::prefix('contacts')->group(function () {
//     Route::post('/from-lead/{leadId}', [ContactController::class, 'createFromLead']);
//     Route::post('/from-account/{accountId}', [ContactController::class, 'createFromAccount']);
// });
