<?php
    use Illuminate\Support\Facades\Route;

    use App\Http\Controllers\Auth\ResponsablePersonnel\ResponsablePersonnelController;
    use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;
    use App\Http\Controllers\Globale\ConversationController;
use App\Http\Controllers\Globale\MessageController;
    Route::group(['prefix' => 'auth-responsable-personnel'], function () {
            Route::group(['middleware'=>['auth:sanctum']], function() {
                        Route::post('/sendImage',[ResponsablePersonnelController::class,'sendImage']);
                        Route::post('/destroyImage',[ResponsablePersonnelController::class,'destroyImage']);
                        Route::post('/getConversations' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);
                        Route::get('/allOuvriers',[AuthOuvrierController::class,'allOuvriers']);
            });
    });
