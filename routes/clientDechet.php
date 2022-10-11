<?php

    use App\Http\Controllers\ClientDechet\DashboradClientDechetController;


    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\DechetController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\Commande_dechetController;
    use App\Http\Controllers\Globale\ConversationController;
    use App\Http\Controllers\Globale\MessageController;

    Route::group(['prefix' => 'auth-client-dechet'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::group(['middleware' => 'auth:client_dechet'], function() {
                    Route::get('/historique-commande-client',[DashboradClientDechetController::class,'HistoriqueCommandeClient']);
                    Route::get('/max3-montant-commande-client',[DashboradClientDechetController::class,'Top3PrixCommandeClient']);
                    Route::get('/dernier3-commande-client',[DashboradClientDechetController::class,'Last3CommandeClient']);
                    Route::get('/commande-client-sans-livraison',[DashboradClientDechetController::class,'SansLivraisonCommandeClient']);


                    Route::get('/quantite-dechet-achete-total-client', [DashboradClientDechetController::class, 'QuantiteDechetAcheteClient']);
                    Route::get('/somme-total-dechet-reschool', [DashboradClientDechetController::class, 'SommeDechetTotaleReschool']);
                    Route::get('/stock-dechet-actuelle', [DashboradClientDechetController::class, 'StockDechetActuelle']);

                    Route::get('/quantite-dechet-achete-mois', [DashboradClientDechetController::class, 'QuantiteDechetAcheteparMois']);

                    Route::get('/quantite-dechet-achete-annee', [DashboradClientDechetController::class, 'QuantiteDechetAcheteAnnees']);




                    Route::apiResource('dechets', DechetController::class);
                    // Route::post('/panier' , [DechetController::class ,'panier']);
                    Route::post('/afficherDechetsClient',[Commande_dechetController::class , 'afficherDechetsClient']);

                    Route::post('/getConversations' , [ConversationController::class , 'index']);
                    Route::post('/getConversationId/{id}' , [ConversationController::class , 'getConversationId']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);

                });
        });
});




// const sommeURL = baseURL + '/api/somme-total-dechet-zone-depot';

// const dechetsURL = baseURL + '/api/dechets';

// const commanderURL = baseURL + api + '/panier';

// const afficherDechetsClientURL = baseURL + api + '/afficherDechetsClient';

// const afficherDetailsDechetURL = baseURL + api + '/afficherDetailsDechet';
