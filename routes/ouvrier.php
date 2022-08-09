<?php
    use App\Http\Controllers\Ouvrier\ViderController;
    use App\Http\Controllers\Ouvrier\GoogleMapController;

    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Auth\ResponsablePersonnel\ResponsablePersonnelController;
    use App\Http\Controllers\Globale\RegionController;
    use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;

    use App\Http\Controllers\Globale\ConversationController;
    use App\Http\Controllers\Globale\MessageController;
    use App\Http\Controllers\Globale\ViderPoubellesController;

Route::put('confirme-planning-ouvrier/{id}',[AuthOuvrierController::class, 'confirmePlanningOuvrier']);
Route::group(['prefix' => 'auth-ouvrier'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::group(['middleware' => 'auth:ouvrier'], function() {
                    Route::post('/modifier-ouvrier-password/{email}',[AuthOuvrierController::class,'modifierPasswordOuvrier']);
                    Route::post('/sendImage',[AuthOuvrierController::class,'sendImage']);
                    Route::post('/destroyImage',[AuthOuvrierController::class,'destroyImage']);
                    Route::get('/camion',[RegionController::class, 'OuvrierCamion']);
                    Route::get('/map',[GoogleMapController::class, 'OuvrierMap']);

                    Route::post('/getConversations' , [ConversationController::class , 'index']);
                    Route::post('/getConversationId/{id}' , [ConversationController::class , 'getConversationId']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);

                    Route::post('/responsable' , [ResponsableCommercialController::class , 'allResponsableCommercials']);

                    Route::post('/responsable' , [ResponsablePersonnelController::class , 'allResponsablePersonnels']);

                    Route::get('/viderPoubelle/{poubelle}', [ViderPoubellesController::class, 'VidagePoubelle']);
                    Route::post('/viderPoubelleQr/{qr}', [ViderController::class, 'ViderPoubelleQr']);
                    Route::get('/viderCamion', [ViderController::class, 'ViderCamion']);
                });
        });
    });
