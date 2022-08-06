<?php
        use App\Http\Controllers\API\Dashboard\GestionnaireDashboardController;
        use App\Http\Controllers\API\Dashboard\SommeDechetController;
        use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
        use Illuminate\Support\Facades\Route;
        use App\Http\Controllers\API\GestionPoubelleEtablissements\Bloc_etablissementsController;
        use App\Http\Controllers\API\GestionPoubelleEtablissements\Etage_etablissementsControlller;

        use App\Http\Controllers\API\TransportDechet\DepotController;
        use App\Http\Controllers\API\TransportDechet\Zone_depotController;
        use App\Http\Controllers\API\TransportDechet\CamionController;

        use App\Http\Controllers\API\ProductionPoubelle\FournisseurController;
        use App\Http\Controllers\API\ProductionPoubelle\StockPoubelleController;
        use App\Http\Controllers\API\ProductionPoubelle\MateriauxPrimaireController;

        use App\Http\Controllers\API\GestionCompte\GestionnaireController;
        use App\Http\Controllers\API\GestionCompte\Client_dechetController;
        use App\Http\Controllers\API\GestionCompte\OuvrierController;
        use App\Http\Controllers\API\GestionCompte\ResponsableEtablissementController;

        use App\Http\Controllers\API\GestionDechet\Commande_dechetController;
        use App\Http\Controllers\API\GestionDechet\DechetController;
        use App\Http\Controllers\API\GestionDechet\Detail_commande_dechetController;

        use App\Http\Controllers\API\GestionPanne\MecanicienController;
        use App\Http\Controllers\API\GestionPanne\Reparation_camionController;
        use App\Http\Controllers\API\GestionPanne\Reparateur_poubelleController;
        use App\Http\Controllers\API\GestionPanne\Reparation_poubelleController;

        use App\Http\Controllers\API\GestionPoubelleEtablissements\Bloc_poubelleController;
        use App\Http\Controllers\API\GestionPoubelleEtablissements\EtablissementController;
        use App\Http\Controllers\API\GestionPoubelleEtablissements\Zone_travailController;
        use App\Http\Controllers\API\GestionPoubelleEtablissements\PoubelleController;
use App\Http\Controllers\API\ResponsableEtablissement\SituationFinanciereController;
use App\Http\Controllers\Globale\ConversationController;
    use App\Http\Controllers\Globale\MessageController;


        
        Route::get('/etablissement-all-details',[PoubelleController::class,"etablissementAllDetails"]);


        Route::get('/bloc-etablissement-liste/{etab}',[PoubelleController::class,"BlocEtablissementListe"]);
        Route::get('/etage-etablissement-liste/{etab}/{bloc_etab}',[PoubelleController::class,"EtageEtablissementListe"]);
        Route::get('/bloc-poubelle-liste/{etab}/{bloc_etab}/{etage}',[PoubelleController::class,"BlocPoubelleListe"]);
        
        
        Route::get('/situation-financiere-gestionnaire-jour', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireJour']);
        Route::get('/situation-financiere-gestionnaire-mensuel', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireMensuel']);

    /**--------------  **************           debut crud       ************************** -------------------**/
        /** -------------------------------------------gestion Compte -----------------------------------------*/
                    /**                 administrateurs                        */
                    Route::apiResource('gestionnaire', GestionnaireController::class);
                    Route::delete('/gestionnaire/hard-delete/{id}', [GestionnaireController::class, 'hdelete']);
                    Route::get('/gestionnaire/restore/{id}', [GestionnaireController::class, 'restore']);
                    Route::get('/admin/restoreall', [GestionnaireController::class, 'restoreAll']);
                    Route::get('/admin/trash', [GestionnaireController::class, 'gestionnairetrash']);
                        /**                 client                                  */
                    Route::apiResource('client', Client_dechetController::class);

                        /**                  ouvrier                                */
                    Route::apiResource('ouvrier', OuvrierController::class);

                        /**                  responsable etablissement              */
                    Route::apiResource('responsable-etablissement', ResponsableEtablissementController::class);
            /** -------------------------------------------gestion Dechet -----------------------------------------*/
                        /**                  commandes                     */
                    Route::apiResource('commande-dechet', Commande_dechetController::class);
                        /**                  dechets                       */
                    Route::apiResource('dechets', DechetController::class);
                    /**                  detail commande dechet         */
                    Route::apiResource('detail-commande-dechets', Detail_commande_dechetController::class);
            /** -------------------------------------------gestion Panne -----------------------------------------*/
                    /**                        reparateur poubelle             */
                    Route::apiResource('reparateur-poubelle', Reparateur_poubelleController::class);
                    /**                        mecanicien                  */
                    Route::apiResource('mecanicien', MecanicienController::class);
                    /**                        reparation poubelle            */
                    Route::apiResource('reparation-poubelle', Reparation_poubelleController::class);
                    /**                        reparation camion               */
                    Route::apiResource('reparation-camion', Reparation_camionController::class);
            /** -------------------------------------------gestion Poubelle par etablissement -----------------------------------------------*/
                        /**                   zone-travail                        */
                    Route::apiResource('zone-travail', Zone_travailController::class);
                            /**                  etablissement                      */
                    Route::apiResource('etablissement', EtablissementController::class);

                            /**                bloc   etablissements                      */
                    Route::apiResource('bloc-etablissement', Bloc_etablissementsController::class);


                            /**                etage etablissements                      */
                    Route::apiResource('etage-etablissement', Etage_etablissementsControlller::class);

                            /**                  bloc-poubelle                      */
                    Route::apiResource('bloc-poubelle', Bloc_poubelleController::class);
                            /**                    poubelle                        */
                    Route::apiResource('poubelle', PoubelleController::class);

            /** -------------------------------------------transport poubelle -----------------------------------------*/
                        /**                       camion                            */
                Route::apiResource('camion', CamionController::class);
                        /**                        zone depot                       */
                Route::apiResource('zone-depot', Zone_depotController::class);
                        /**                       depot                            */
                Route::apiResource('depot', DepotController::class);
            /** -------------------------------------------production poubelle -----------------------------------------*/
                    /**                   Fournisseur                         */
                Route::apiResource('fournisseurs', FournisseurController::class);
                    /**                    Materiaux Primaires               */
                Route::apiResource('materiaux-primaires',MateriauxPrimaireController::class);
                    /**                   Stock poubelle                  */
                Route::apiResource('stock-poubelle', StockPoubelleController::class);
                Route::post('/update-stock-image/{id}', [StockPoubelleController::class, 'updateStockImage']);


    /**--------------  **************          fin crud          ************************** -------------------**/

    /** -------------  **************         debut dashborad gestionnaire      **************************  ------------------**/
          Route::get('/dashboard', [GestionnaireDashboardController::class, 'dashbordValeur']);

          Route::get('/stock-poubelles-dashboard', [GestionnaireDashboardController::class, 'stockPoubelles']);
          Route::get('/etablissements-poubelles-dashboard', [GestionnaireDashboardController::class, 'poubellesEtablissement']);


          Route::get('/commandes-dechets-dashboard', [GestionnaireDashboardController::class, 'CommandesDechets']);
          Route::get('/collecte-dechets-dashboard', [GestionnaireDashboardController::class, 'collecteDechets']);


          Route::get('/personnels-dashboard', [GestionnaireDashboardController::class, 'personnels']);


          Route::get('/camions-dashboard', [GestionnaireDashboardController::class, 'camions']);


    Route::get('/somme-dechets-depot-par-mois', [SommeDechetController::class, 'sommeDechetsDepotparMois']);
    Route::get('/somme-dechet-annees', [SommeDechetController::class, 'sommeDechetAnnees']);
    Route::get('/somme-dechets-vendus', [SommeDechetController::class, 'sommeDechetsVendus']);

    Route::get('/pannes-dashboard', [GestionnaireDashboardController::class, 'pannes']);

    Route::get('/pannes-camion-mois', [GestionnaireDashboardController::class, 'PanneCamionparMois']);
    Route::get('/pannes-poubelle-mois', [GestionnaireDashboardController::class, 'PannePoubelleparMois']);

    Route::get('/pannes-poubelle-annee', [GestionnaireDashboardController::class, 'PannesPoubelleAnnees']);
    Route::get('/pannes-camion-annee', [GestionnaireDashboardController::class, 'PannesCamionAnnees']);


    /** -------------  **************         fin dashborad gestionnaire      **************************  ------------------**/

    Route::group(['prefix' => 'auth-gestionnaire'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
                Route::group(['middleware' => 'auth:gestionnaire'], function() {
                    Route::post('/modifier-gestionnaire-password',[AuthGestionnaireController::class,'modifierPasswordGestionnaire']);
                    Route::post('/send',[AuthGestionnaireController::class,'send']);
                    Route::post('/sendImage',[AuthGestionnaireController::class,'sendImage']);
                    Route::post('/destroyImage',[AuthGestionnaireController::class,'destroyImage']);
                    Route::post('/getConversations' , [ConversationController::class , 'index']);
                    Route::post('/conversation' , [ConversationController::class , 'store']);
                    Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                    Route::post('/message' , [MessageController::class , 'store']);
                });

                Route::get('/checkingAuthGestionnaire' , function(){
                    return response()->json(['message'=>'gestionnaire vous avez connecté','status'=>200],200);
                });
         });
});

