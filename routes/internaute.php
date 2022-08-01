<?php

use App\Http\Controllers\API\Dashboard\InternauteDashboardController;
use Illuminate\Support\Facades\Route;

    Route::group(['prefix' => 'internaute'], function () {
        Route::get('/dashborad' , [InternauteDashboardController::class , 'dashbordInternaute']);

    });

