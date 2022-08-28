<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Globale\ConversationController;
use App\Http\Controllers\Globale\MessageController;
    Route::group(['prefix' => 'auth-responsable-technique'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::post('/getConversations' , [ConversationController::class , 'index']);
            Route::post('/conversation' , [ConversationController::class , 'store']);
            Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
            Route::post('/message' , [MessageController::class , 'store']);
        });
    });
