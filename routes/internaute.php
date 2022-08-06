<?php
use App\Http\Controllers\Internaute\InternauteDashboardController;
use App\Http\Controllers\Internaute\ContactsController;
use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'internaute'], function () {
    Route::get('/dashborad' , [InternauteDashboardController::class , 'dashbordInternaute']);
    Route::apiResource('contact-us', ContactsController::class);
});