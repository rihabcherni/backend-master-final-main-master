<?php
use Illuminate\Support\Facades\Route;
/**                              dashboard                 */
    use App\Http\Controllers\Gestionnaire\DashboardGestionnaire\GestionPannesController;
    use App\Http\Controllers\Gestionnaire\DashboardGestionnaire\GlobalStatController;
/**                              dashboard                 */

/*                                 crud                     */
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\GestionnaireController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\Client_dechetController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\OuvrierController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\ResponsableEtablissementController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\ResponsableCommercialeController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte\ResponsablePersonnelController;

    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\Commande_dechetController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\DechetController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet\Detail_commande_dechetController;

    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne\MecanicienController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne\Reparation_camionController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne\Reparateur_poubelleController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne\Reparation_poubelleController;

    use App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet\DepotController;
    use App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet\Zone_depotController;
    use App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet\CamionController;

    use App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle\FournisseurController;
    use App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle\StockPoubelleController;
    use App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle\MateriauxPrimaireController;

    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\Zone_travailController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\EtablissementController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\Bloc_etablissementsController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\Etage_etablissementsControlller;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\Bloc_poubelleController;
    use App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements\PoubelleController;

/*                                 crud                     */
use App\Http\Controllers\Gestionnaire\RechercheGestionnaireController;


        use App\Http\Controllers\Globale\SommeDechetController;
        use App\Http\Controllers\Auth\Gestionnaire\AuthGestionnaireController;
use App\Http\Controllers\ResponsableEtablissement\SituationFinanciereController;
use App\Http\Controllers\Globale\ConversationController;
use App\Http\Controllers\Globale\MessageController;


/**                              debut dashboard                            */
    Route::get('/dashboard', [GlobalStatController::class, 'statGetionnaire']);
    /**                             Panne                 */
        Route::get('/pannes-dashboard', [GestionPannesController::class, 'pannes']);
        Route::get('/pannes-camion-mois', [GestionPannesController::class, 'PanneCamionparMois']);
        Route::get('/pannes-poubelle-mois', [GestionPannesController::class, 'PannePoubelleparMois']);
        Route::get('/pannes-poubelle-annee', [GestionPannesController::class, 'PannesPoubelleAnnees']);
        Route::get('/pannes-camion-annee', [GestionPannesController::class, 'PannesCamionAnnees']);
    /**                             Panne                 */

/**                              fin dashboard                             */

/**                               debut crud                          **/
        /** -------------------------------------------gestion Compte -----------------------------------------*/
            /**                 gestionnaire                        */
                Route::apiResource('gestionnaire', GestionnaireController::class);
                Route::delete('/gestionnaire/hard-delete/{id}', [GestionnaireController::class, 'hdelete']);
                Route::get('/gestionnaire/restore/{id}', [GestionnaireController::class, 'restore']);
                Route::get('/admin/restoreall', [GestionnaireController::class, 'restoreAll']);
                Route::get('/admin/trash', [GestionnaireController::class, 'gestionnairetrash']);
            /**                 client                                  */
                Route::apiResource('client', Client_dechetController::class);
                Route::apiResource('ouvrier', OuvrierController::class);
                Route::apiResource('responsable-commercial', ResponsableCommercialeController::class);
                Route::apiResource('responsable-personnel', ResponsablePersonnelController::class);
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

/**                               fin crud                            **/

/**                               debut Rechecher                          **/
        Route::get('/bloc-etablissement-liste/{etab}',[RechercheGestionnaireController::class,"BlocEtablissementListe"]);
        Route::get('/etage-etablissement-liste/{etab}/{bloc_etab}',[RechercheGestionnaireController::class,"EtageEtablissementListe"]);
        Route::get('/bloc-poubelle-liste/{etab}/{bloc_etab}/{etage}',[RechercheGestionnaireController::class,"BlocPoubelleListe"]);
/**                               fin Rechecher                          **/

        Route::get('/situation-financiere-gestionnaire-jour', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireJour']);
        Route::get('/situation-financiere-gestionnaire-mensuel', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireMensuel']);


    Route::get('/somme-dechets-depot-par-mois', [SommeDechetController::class, 'sommeDechetsDepotparMois']);
    Route::get('/somme-dechet-annees', [SommeDechetController::class, 'sommeDechetAnnees']);
    Route::get('/somme-dechets-vendus', [SommeDechetController::class, 'sommeDechetsVendus']);
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

