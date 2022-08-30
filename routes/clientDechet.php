<?php

    use App\Http\Controllers\ClientDechet\ClientDechetController;


    use App\Http\Controllers\Globale\SommeDechetController;
    use App\Http\Controllers\Auth\ClientDechet\AuthClientDechetController;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\DechetController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\Commande_dechetController;
    use App\Http\Controllers\Globale\ConversationController;
    use App\Http\Controllers\Globale\MessageController;

    Route::group(['prefix' => 'auth-client-dechet'], function () {

        Route::group(['middleware'=>['auth:sanctum']], function() {

                Route::group(['middleware' => 'auth:client_dechet'], function() {

                    Route::get('/commande-client',[ClientDechetController::class,'ClientCommande']);


                    Route::apiResource('dechets', DechetController::class);
                    Route::post('/send',[AuthClientDechetController::class,'send']);

                    Route::post('/afficherDechetsClient',[Commande_dechetController::class , 'afficherDechetsClient']);

                    Route::post('/getConversations' , [ConversationController::class , 'index']);
                    Route::post('/getConversationId/{id}' , [ConversationController::class , 'getConversationId']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);

                    // Route::post('/panier' , [DechetController::class ,'panier']);

                    Route::get('/quantite-dechet-total-client', [SommeDechetController::class, 'QuantiteDechetTotaleClient']);
                });
        });
});

