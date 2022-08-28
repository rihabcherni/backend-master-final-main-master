<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\ResponsableCommercial\ResponsableCommercialController;
    use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
    use App\Http\Controllers\Globale\ConversationController;
use App\Http\Controllers\Globale\MessageController;
    Route::group(['prefix' => 'auth-responsable-commercial'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::post('/sendImage',[ResponsableCommercialController::class,'sendImage']);
            Route::post('/destroyImage',[ResponsableCommercialController::class,'destroyImage']);
            Route::post('/getConversations' , [ConversationController::class , 'index']);
            Route::post('/conversation' , [ConversationController::class , 'store']);
            Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
            Route::post('/message' , [MessageController::class , 'store']);
            Route::get('/all-client-dechets',[AuthClientDechetController::class,'allClientDechets']);
        });
    });
