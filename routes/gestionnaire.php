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
use App\Http\Resources\GestionCompte\Gestionnaire as GestionnaireResource;
use App\Models\Gestionnaire;

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
                Route::get('gestionnaire-excel', [GestionnaireController::class, 'exportInfoGestionnaireExcel']);
                Route::get('gestionnaire-csv', [GestionnaireController::class, 'exportInfoGestionnaireCSV']);
                Route::get('gestionnaire-pdf/{id}', [GestionnaireController::class, 'pdfGestionnaire']);
                Route::get('gestionnaire-all-pdf', [GestionnaireController::class, 'pdfAllGestionnaire']);
            /**                 client                                  */
                Route::apiResource('client-dechets', Client_dechetController::class);
                Route::get('client-dechets-excel', [Client_dechetController::class, 'exportInfoClientDechetExcel']);
                Route::get('client-dechets-csv', [Client_dechetController::class, 'exportInfoClientDechetCSV']);
                Route::get('client-dechets-pdf/{id}', [Client_dechetController::class, 'pdfClientDechet']);
                Route::get('client-dechets-all-pdf', [Client_dechetController::class, 'pdfAllClientDechet']);
            /**                 ouvrier                                  */
                Route::apiResource('ouvrier', OuvrierController::class);
                Route::get('ouvrier-excel', [OuvrierController::class, 'exportInfoOuvrierExcel']);
                Route::get('ouvrier-csv', [OuvrierController::class, 'exportInfoOuvrierCSV']);
                Route::get('ouvrier-pdf/{id}', [OuvrierController::class, 'pdfOuvrier']);
                Route::get('ouvrier-all-pdf', [OuvrierController::class, 'pdfAllOuvrier']);
            /**                 responsable commercial                                  */
                Route::apiResource('responsable-commercial', ResponsableCommercialeController::class);
                Route::get('responsable-commercial-excel', [ResponsableCommercialeController::class, 'exportInfoResponsableCommercialeExcel']);
                Route::get('responsable-commercial-csv', [ResponsableCommercialeController::class, 'exportInfoResponsableCommercialeCSV']);
                Route::get('responsable-commercial-pdf/{id}', [ResponsableCommercialeController::class, 'pdfResponsableCommerciale']);
                Route::get('responsable-commercial-all-pdf', [ResponsableCommercialeController::class, 'pdfAllResponsableCommerciale']);
            /**                 responsable personnel                                  */
                Route::apiResource('responsable-personnel', ResponsablePersonnelController::class);
                Route::get('responsable-personnel-excel', [ResponsablePersonnelController::class, 'exportInfoResponsablePersonnelExcel']);
                Route::get('responsable-personnel-csv', [ResponsablePersonnelController::class, 'exportInfoResponsablePersonnelCSV']);
                Route::get('responsable-personnel-pdf/{id}', [ResponsablePersonnelController::class, 'pdfResponsablePersonnel']);
                Route::get('responsable-personnel-all-pdf', [ResponsablePersonnelController::class, 'pdfAllResponsablePersonnel']);
            /**                 responsable etablissement                                  */
                Route::apiResource('responsable-etablissement', ResponsableEtablissementController::class);
                Route::get('responsable-etablissement-excel', [ResponsableEtablissementController::class, 'exportInfoResponsableEtablissementExcel']);
                Route::get('responsable-etablissement-csv', [ResponsableEtablissementController::class, 'exportInfoResponsableEtablissementCSV']);
                Route::get('responsable-etablissement-pdf/{id}', [ResponsableEtablissementController::class, 'pdfResponsableEtablissement']);
                Route::get('responsable-etablissement-all-pdf', [ResponsableEtablissementController::class, 'pdfAllResponsableEtablissement']);

        /** -------------------------------------------gestion Dechet -----------------------------------------*/
                        /**                  commandes                     */
                    Route::apiResource('commande-dechet', Commande_dechetController::class);
                    Route::get('commande-dechet-excel', [Commande_dechetController::class, 'exportInfoCommandeDechetExcel']);
                    Route::get('commande-dechet-csv', [Commande_dechetController::class, 'exportInfoCommandeDechetCSV']);
                    Route::get('commande-dechet-pdf/{id}', [Commande_dechetController::class, 'pdfCommandeDechet']);
                    Route::get('commande-dechet-all-pdf', [Commande_dechetController::class, 'pdfAllCommandeDechet']);
                        /**                  dechets                       */
                    Route::apiResource('dechets', DechetController::class);
                    Route::get('dechets-excel', [DechetController::class, 'exportInfoDechetExcel']);
                    Route::get('dechets-csv', [DechetController::class, 'exportInfoDechetCSV']);
                    Route::get('dechets-pdf/{id}', [DechetController::class, 'pdfDechet']);
                    Route::get('dechets-all-pdf', [DechetController::class, 'pdfAllDechet']);
                    /**                  detail commande dechet         */
                    Route::apiResource('detail-commande-dechets', Detail_commande_dechetController::class);
                    Route::get('detail-commande-dechets-excel', [Detail_commande_dechetController::class, 'exportInfoDetailCommandeDechetExcel']);
                    Route::get('detail-commande-dechets-csv', [Detail_commande_dechetController::class, 'exportInfoDetailCommandeDechetCSV']);
                   /** -------------------------------------------gestion Panne -----------------------------------------*/
            /**                        reparateur poubelle             */
                Route::apiResource('reparateur-poubelle', Reparateur_poubelleController::class);
                Route::get('reparateur-poubelle-excel', [Reparateur_poubelleController::class, 'exportInfoReparateurPoubelleExcel']);
                Route::get('reparateur-poubelle-csv', [Reparateur_poubelleController::class, 'exportInfoReparateurPoubelleCSV']);
                Route::get('reparateur-poubelle-pdf/{id}', [Reparateur_poubelleController::class, 'pdfReparateurPoubelle']);
                Route::get('reparateur-poubelle-all-pdf', [Reparateur_poubelleController::class, 'pdfAllReparateurPoubelle']);
            /**                        mecanicien                  */
                Route::apiResource('mecanicien', MecanicienController::class);
                Route::get('mecanicien-excel', [MecanicienController::class, 'exportInfoMecanicienExcel']);
                Route::get('mecanicien-csv', [MecanicienController::class, 'exportInfoMecanicienCSV']);
                Route::get('mecanicien-pdf/{id}', [MecanicienController::class, 'pdfMecanicien']);
                Route::get('mecanicien-all-pdf', [MecanicienController::class, 'pdfAllMecanicien']);
            /**                        reparation poubelle            */
                Route::apiResource('reparation-poubelle', Reparation_poubelleController::class);
                Route::get('reparation-poubelle-excel', [Reparation_poubelleController::class, 'exportInfoReparationPoubelleExcel']);
                Route::get('reparation-poubelle-csv', [Reparation_poubelleController::class, 'exportInfoReparationPoubelleCSV']);
                Route::get('reparation-poubelle-pdf/{id}', [Reparation_poubelleController::class, 'pdfReparationPoubelle']);
                Route::get('reparation-poubelle-all-pdf', [Reparation_poubelleController::class, 'pdfAllReparationPoubelle']);
            /**                        reparation camion               */
                Route::apiResource('reparation-camion', Reparation_camionController::class);
                Route::get('reparation-camion-excel', [Reparation_camionController::class, 'exportInfoReparationCamionExcel']);
                Route::get('reparation-camion-csv', [Reparation_camionController::class, 'exportInfoReparationCamionCSV']);
                Route::get('reparation-camion-pdf/{id}', [Reparation_camionController::class, 'pdfReparationCamion']);
                Route::get('reparation-camion-all-pdf', [Reparation_camionController::class, 'pdfAllReparationCamion']);
        /** -------------------------------------------gestion Poubelle par etablissement -----------------------------------------------*/
            /**                   zone-travail                        */
                Route::apiResource('zone-travail', Zone_travailController::class);
                Route::get('zone-travail-excel', [Zone_travailController::class, 'exportInfoZoneTravailExcel']);
                Route::get('zone-travail-csv', [Zone_travailController::class, 'exportInfoZoneTravailCSV']);
                Route::get('zone-travail-pdf/{id}', [Zone_travailController::class, 'pdfZoneTravail']);
                Route::get('zone-travail-all-pdf', [Zone_travailController::class, 'pdfAllZoneTravail']);
            /**                  etablissement                      */
                Route::apiResource('etablissement', EtablissementController::class);
                Route::get('etablissement-excel', [EtablissementController::class, 'exportInfoEtablissementExcel']);
                Route::get('etablissement-csv', [EtablissementController::class, 'exportInfoEtablissementCSV']);
                Route::get('etablissement-pdf/{id}', [EtablissementController::class, 'pdfEtablissement']);
                Route::get('etablissement-all-pdf', [EtablissementController::class, 'pdfAllEtablissement']);
            /**                bloc   etablissements                      */
                Route::apiResource('bloc-etablissement', Bloc_etablissementsController::class);
                Route::get('bloc-etablissement-excel', [Bloc_etablissementsController::class, 'exportInfoBlocEtablissementExcel']);
                Route::get('bloc-etablissement-csv', [Bloc_etablissementsController::class, 'exportInfoBlocEtablissementCSV']);
                Route::get('bloc-etablissement-pdf/{id}', [Bloc_etablissementsController::class, 'pdfBlocEtablissement']);
                Route::get('bloc-etablissement-all-pdf', [Bloc_etablissementsController::class, 'pdfAllBlocEtablissement']);
            /**                etage etablissements                      */
                Route::apiResource('etage-etablissement', Etage_etablissementsControlller::class);
                Route::get('etage-etablissement-excel', [Etage_etablissementsControlller::class, 'exportInfoEtageEtablissementExcel']);
                Route::get('etage-etablissement-csv', [Etage_etablissementsControlller::class, 'exportInfoEtageEtablissementCSV']);
                Route::get('etage-etablissement-pdf/{id}', [Etage_etablissementsControlller::class, 'pdfEtageEtablissement']);
                Route::get('etage-etablissement-all-pdf', [Etage_etablissementsControlller::class, 'pdfAllEtageEtablissement']);
            /**                  bloc-poubelle                      */
                Route::apiResource('bloc-poubelle', Bloc_poubelleController::class);
                Route::get('bloc-poubelle-excel', [Bloc_poubelleController::class, 'exportInfoBlocPoubelleExcel']);
                Route::get('bloc-poubelle-csv', [Bloc_poubelleController::class, 'exportInfoBlocPoubelleCSV']);
                Route::get('bloc-poubelle-pdf/{id}', [Bloc_poubelleController::class, 'pdfBlocPoubelle']);
                Route::get('bloc-poubelle-all-pdf', [Bloc_poubelleController::class, 'pdfAllBlocPoubelle']);
            /**                    poubelle                        */
                Route::apiResource('poubelle', PoubelleController::class,);
                Route::get('poubelle-excel', [PoubelleController::class, 'exportInfoPoubelleExcel']);
                Route::get('poubelle-csv', [PoubelleController::class, 'exportInfoPoubelleCSV']);
                Route::get('poubelle-pdf/{id}', [PoubelleController::class, 'pdfPoubelle']);
                Route::get('poubelle-all-pdf', [PoubelleController::class, 'pdfAllPoubelle']);
        /** -------------------------------------------transport poubelle -----------------------------------------*/
            /**                       camion                            */
                Route::apiResource('camion', CamionController::class);
                Route::get('camion-excel', [CamionController::class, 'exportInfoCamionExcel']);
                Route::get('camion-csv', [CamionController::class, 'exportInfoCamionCSV']);
                Route::get('camion-pdf/{id}', [CamionController::class, 'pdfCamion']);
                Route::get('camion-all-pdf', [CamionController::class, 'pdfAllCamion']);

            /**                        zone depot                        */
                Route::apiResource('zone-depot', Zone_depotController::class);
                Route::get('zone-depot-excel', [Zone_depotController::class, 'exportInfoZoneDepotExcel']);
                Route::get('zone-depot-csv', [Zone_depotController::class, 'exportInfoZoneDepotCSV']);
                Route::get('zone-depot-pdf/{id}', [Zone_depotController::class, 'pdfZoneDepot']);
                Route::get('zone-depot-all-pdf', [Zone_depotController::class, 'pdfAllZoneDepot']);
            /**                       depot                            */
                Route::apiResource('depot', DepotController::class);
                Route::get('depot-excel', [DepotController::class, 'exportInfoDepotExcel']);
                Route::get('depot-csv', [DepotController::class, 'exportInfoDepotCSV']);
                Route::get('depot-pdf/{id}', [DepotController::class, 'pdfDepot']);
                Route::get('depot-all-pdf', [DepotController::class, 'pdfAllDepot']);

        /** -------------------------------------------production poubelle -----------------------------------------*/
            /**                   Fournisseur                         */
                Route::apiResource('fournisseurs', FournisseurController::class);
                Route::get('fournisseurs-excel', [FournisseurController::class, 'exportInfoFournisseurExcel']);
                Route::get('fournisseurs-csv', [FournisseurController::class, 'exportInfoFournisseurCSV']);
                Route::get('fournisseurs-pdf/{id}', [FournisseurController::class, 'pdfFournisseur']);
                Route::get('fournisseurs-all-pdf', [FournisseurController::class, 'pdfAllFournisseur']);

            /**                    Materiaux Primaires               */
                Route::apiResource('materiaux-primaires',MateriauxPrimaireController::class);
                Route::get('materiaux-primaires-excel', [MateriauxPrimaireController::class, 'exportInfoMateriauxPrimaireExcel']);
                Route::get('materiaux-primaires-csv', [MateriauxPrimaireController::class, 'exportInfoMateriauxPrimaireCSV']);
                Route::get('materiaux-primaires-pdf/{id}', [MateriauxPrimaireController::class, 'pdfMateriauxPrimaire']);
                Route::get('materiaux-primaires-all-pdf', [MateriauxPrimaireController::class, 'pdfAllMateriauxPrimaire']);

            /**                   Stock poubelle                  */
                Route::apiResource('stock-poubelle', StockPoubelleController::class);
                Route::get('stock-poubelle-excel', [StockPoubelleController::class, 'exportInfoStockPoubelleExcel']);
                Route::get('stock-poubelle-csv', [StockPoubelleController::class, 'exportInfoStockPoubelleCSV']);
                Route::get('stock-poubelle-pdf/{id}', [StockPoubelleController::class, 'pdfStockPoubelle']);
                Route::get('stock-poubelle-all-pdf', [StockPoubelleController::class, 'pdfAllStockPoubelle']);

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


