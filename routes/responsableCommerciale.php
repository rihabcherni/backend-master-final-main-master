<?php
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\ResponsableCommercial\ResponsableCommercialController;
    use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
    use App\Http\Controllers\ConversationController;
    use App\Http\Controllers\MessageController;

    Route::group(['prefix' => 'auth-responsable-commercial'], function () {
        Route::post('/qrlogin/{email}',[ResponsableCommercialController::class, 'qrlogin']);

            Route::group(['middleware'=>['auth:sanctum']], function() {
                        Route::post('/modifier-responsable-commercial-password/{email}',[ResponsableCommercialController::class,'modifierPasswordResponsableCommercial']);
                        Route::post('/sendImage',[ResponsableCommercialController::class,'sendImage']);
                        Route::post('/destroyImage',[ResponsableCommercialController::class,'destroyImage']);
                        Route::post('/getConversations' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);

                        Route::get('/allClient',[AuthClientDechetController::class,'allClientDechets']);
            });
    });
