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
    use App\Http\Controllers\Ouvrier\PlanningOuvrierController;
Route::group(['prefix' => 'auth-ouvrier'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::group(['middleware' => 'auth:ouvrier'], function() {
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

                    Route::get('/vider-poubelle/{poubelle}', [ViderController::class, 'VidagePoubelle']);
                    Route::post('/vider-poubelleQr/{qr}', [ViderController::class, 'ViderPoubelleQr']);
                    Route::get('/vider-camion', [ViderController::class, 'ViderCamion']);
                    Route::get('/planning-ouvrier', [PlanningOuvrierController::class, 'planningOuvrier']);

                });
        });
    });
