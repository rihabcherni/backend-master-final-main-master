<?php
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\Auth\ResponsablePersonnel\ResponsablePersonnelController;
    use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;
    use App\Http\Controllers\ConversationController;
    use App\Http\Controllers\MessageController;

    Route::group(['prefix' => 'auth-responsable-personnel'], function () {
        Route::post('/qrlogin/{email}',[ResponsablePersonnelController::class, 'qrlogin']);

            Route::group(['middleware'=>['auth:sanctum']], function() {
                        Route::post('/modifier-responsable-Personnel-password/{email}',[ResponsablePersonnelController::class,'modifierPasswordResponsablePersonnel']);
                        Route::post('/sendImage',[ResponsablePersonnelController::class,'sendImage']);
                        Route::post('/destroyImage',[ResponsablePersonnelController::class,'destroyImage']);
                        Route::post('/getConversations' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);

                        Route::get('/allOuvriers',[AuthOuvrierController::class,'allOuvriers']);
            });
    });
