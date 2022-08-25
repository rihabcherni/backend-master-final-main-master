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
/**                                debut dashboard                            */
    Route::get('/dashboard', [GlobalStatController::class, 'statGetionnaire']);
/**                                Panne                                      */
        Route::get('/pannes-dashboard', [GestionPannesController::class, 'pannes']);
        Route::get('/pannes-camion-mois', [GestionPannesController::class, 'PanneCamionparMois']);
        Route::get('/pannes-poubelle-mois', [GestionPannesController::class, 'PannePoubelleparMois']);
        Route::get('/pannes-poubelle-annee', [GestionPannesController::class, 'PannesPoubelleAnnees']);
        Route::get('/pannes-camion-annee', [GestionPannesController::class, 'PannesCamionAnnees']);
/**                               debut crud                                  */
        /** -------------------------------------------gestion Compte -----------------------------------------*/
            /**                 gestionnaire                        */
                Route::controller(GestionnaireController::class)->group(function () {
                    Route::get('gestionnaire-liste-suppression', 'listeSuppression');
                    Route::get('gestionnaire-excel', 'exportInfoExcel');
                    Route::get('gestionnaire-csv', 'exportInfoCSV');
                    Route::get('gestionnaire-pdf/{id}', 'pdf');
                    Route::get('gestionnaire-all-pdf', 'pdfAll');
                    Route::get('gestionnaire-restore/{id}', 'restore');
                    Route::get('gestionnaire-restore-all', 'restoreAll');
                    Route::get('gestionnaire-suppression-definitif/{id}', 'hdelete');
                    Route::get('gestionnaire-suppression-definitif-all', 'hdeleteAll');
                    Route::get('gestionnaire-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('gestionnaire-all-pdf-trashed', 'pdfAllTrashed');

                });
                Route::apiResource('gestionnaire', GestionnaireController::class);
            /**                 client                                  */
                Route::apiResource('client-dechets', Client_dechetController::class);
                Route::controller(Client_dechetController::class)->group(function () {
                    Route::get('client-dechets-liste-suppression', 'listeSuppression');
                    Route::get('client-dechets-excel', 'exportInfoExcel');
                    Route::get('client-dechets-csv', 'exportInfoCSV');
                    Route::get('client-dechets-pdf/{id}', 'pdf');
                    Route::get('client-dechets-all-pdf', 'pdfAll');
                    Route::get('client-dechets-restore/{id}', 'restore');
                    Route::get('client-dechets-restore-all', 'restoreAll');
                    Route::get('client-dechets-suppression-definitif/{id}', 'hdelete');
                    Route::get('client-dechets-suppression-definitif-all', 'hdeleteAll');
                    Route::get('client-dechets-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('client-dechets-all-pdf-trashed', 'pdfAllTrashed');

                });
            /**                 ouvrier                                  */
                Route::apiResource('ouvrier', OuvrierController::class);
                Route::controller(OuvrierController::class)->group(function () {
                    Route::get('ouvrier-liste-suppression', 'listeSuppression');
                    Route::get('ouvrier-excel', 'exportInfoExcel');
                    Route::get('ouvrier-csv', 'exportInfoCSV');
                    Route::get('ouvrier-pdf/{id}', 'pdf');
                    Route::get('ouvrier-all-pdf', 'pdfAll');
                    Route::get('ouvrier-restore/{id}', 'restore');
                    Route::get('ouvrier-restore-all', 'restoreAll');
                    Route::get('ouvrier-suppression-definitif/{id}', 'hdelete');
                    Route::get('ouvrier-suppression-definitif-all', 'hdeleteAll');
                    Route::get('ouvrier-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('ouvrier-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                 responsable commercial                                  */
                Route::apiResource('responsable-commercial', ResponsableCommercialeController::class);
                Route::controller(ResponsableCommercialeController::class)->group(function () {
                    Route::get('responsable-commercial-liste-suppression', 'listeSuppression');
                    Route::get('responsable-commercial-excel', 'exportInfoExcel');
                    Route::get('responsable-commercial-csv', 'exportInfoCSV');
                    Route::get('responsable-commercial-pdf/{id}', 'pdf');
                    Route::get('responsable-commercial-all-pdf', 'pdfAll');
                    Route::get('responsable-commercial-restore/{id}', 'restore');
                    Route::get('responsable-commercial-restore-all', 'restoreAll');
                    Route::get('responsable-commercial-suppression-definitif/{id}', 'hdelete');
                    Route::get('responsable-commercial-suppression-definitif-all', 'hdeleteAll');
                    Route::get('responsable-commercial-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('responsable-commercial-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                 responsable personnel                                  */
                Route::apiResource('responsable-personnel', ResponsablePersonnelController::class);
                Route::controller(ResponsablePersonnelController::class)->group(function () {
                    Route::get('responsable-personnel-liste-suppression', 'listeSuppression');
                    Route::get('responsable-personnel-excel', 'exportInfoExcel');
                    Route::get('responsable-personnel-csv', 'exportInfoCSV');
                    Route::get('responsable-personnel-pdf/{id}', 'pdf');
                    Route::get('responsable-personnel-all-pdf', 'pdfAll');
                    Route::get('responsable-personnel-restore/{id}', 'restore');
                    Route::get('responsable-personnel-restore-all', 'restoreAll');
                    Route::get('responsable-personnel-suppression-definitif/{id}', 'hdelete');
                    Route::get('responsable-personnel-suppression-definitif-all', 'hdeleteAll');
                    Route::get('responsable-personnel-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('responsable-personnel-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                 responsable etablissement                                  */
                Route::apiResource('responsable-etablissement', ResponsableEtablissementController::class);
                Route::controller(ResponsableEtablissementController::class)->group(function () {
                    Route::get('responsable-etablissement-liste-suppression', 'listeSuppression');
                    Route::get('responsable-etablissement-excel', 'exportInfoExcel');
                    Route::get('responsable-etablissement-csv', 'exportInfoCSV');
                    Route::get('responsable-etablissement-pdf/{id}', 'pdf');
                    Route::get('responsable-etablissement-all-pdf', 'pdfAll');
                    Route::get('responsable-etablissement-restore/{id}', 'restore');
                    Route::get('responsable-etablissement-restore-all', 'restoreAll');
                    Route::get('responsable-etablissement-suppression-definitif/{id}', 'hdelete');
                    Route::get('responsable-etablissement-suppression-definitif-all', 'hdeleteAll');
                    Route::get('responsable-etablissement-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('responsable-etablissement-all-pdf-trashed', 'pdfAllTrashed');
                });
        /** -------------------------------------------gestion Dechet -----------------------------------------*/
                /**                  commandes                     */
                    Route::apiResource('commande-dechet', Commande_dechetController::class);
                    Route::controller(Commande_dechetController::class)->group(function () {
                        Route::get('commande-dechet-liste-suppression', 'listeSuppression');
                        Route::get('commande-dechet-excel', 'exportInfoExcel');
                        Route::get('commande-dechet-csv', 'exportInfoCSV');
                        Route::get('commande-dechet-pdf/{id}', 'pdf');
                        Route::get('commande-dechet-all-pdf', 'pdfAll');
                        Route::get('commande-dechet-restore/{id}', 'restore');
                        Route::get('commande-dechet-restore-all', 'restoreAll');
                        Route::get('commande-dechet-suppression-definitif/{id}', 'hdelete');
                        Route::get('commande-dechet-suppression-definitif-all', 'hdeleteAll');
                        Route::get('commande-dechet-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('commande-dechet-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                  dechets                       */
                    Route::apiResource('dechets', DechetController::class);
                    Route::controller(DechetController::class)->group(function () {
                        Route::get('dechets-liste-suppression', 'listeSuppression');
                        Route::get('dechets-excel', 'exportInfoExcel');
                        Route::get('dechets-csv', 'exportInfoCSV');
                        Route::get('dechets-pdf/{id}', 'pdf');
                        Route::get('dechets-all-pdf', 'pdfAll');
                        Route::get('dechets-restore/{id}', 'restore');
                        Route::get('dechets-restore-all', 'restoreAll');
                        Route::get('dechets-suppression-definitif/{id}', 'hdelete');
                        Route::get('dechets-suppression-definitif-all', 'hdeleteAll');
                        Route::get('dechets-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('dechets-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                  detail commande dechet         */
                    Route::apiResource('detail-commande-dechets', Detail_commande_dechetController::class);
                    Route::controller(Detail_commande_dechetController::class)->group(function () {
                        Route::get('detail-commande-dechets-liste-suppression', 'listeSuppression');
                        Route::get('detail-commande-dechets-excel', 'exportInfoExcel');
                        Route::get('detail-commande-dechets-csv', 'exportInfoCSV');
                        Route::get('detail-commande-dechets-pdf/{id}', 'pdf');
                        Route::get('detail-commande-dechets-all-pdf', 'pdfAll');
                        Route::get('detail-commande-dechets-restore/{id}', 'restore');
                        Route::get('detail-commande-dechets-restore-all', 'restoreAll');
                        Route::get('detail-commande-dechets-suppression-definitif/{id}', 'hdelete');
                        Route::get('detail-commande-dechets-suppression-definitif-all', 'hdeleteAll');
                        Route::get('detail-commande-dechets-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('detail-commande-dechets-all-pdf-trashed', 'pdfAllTrashed');
                    });
        /** -------------------------------------------gestion Panne -----------------------------------------*/
                /**                        reparateur poubelle             */
                    Route::apiResource('reparateur-poubelle', Reparateur_poubelleController::class);
                    Route::controller(Reparateur_poubelleController::class)->group(function () {
                        Route::get('reparateur-poubelle-liste-suppression', 'listeSuppression');
                        Route::get('reparateur-poubelle-excel', 'exportInfoExcel');
                        Route::get('reparateur-poubelle-csv', 'exportInfoCSV');
                        Route::get('reparateur-poubelle-pdf/{id}', 'pdf');
                        Route::get('reparateur-poubelle-all-pdf', 'pdfAll');
                        Route::get('reparateur-poubelle-restore/{id}', 'restore');
                        Route::get('reparateur-poubelle-restore-all', 'restoreAll');
                        Route::get('reparateur-poubelle-suppression-definitif/{id}', 'hdelete');
                        Route::get('reparateur-poubelle-suppression-definitif-all', 'hdeleteAll');
                        Route::get('reparateur-poubelle-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('reparateur-poubelle-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                        mecanicien                  */
                    Route::apiResource('mecanicien', MecanicienController::class);
                    Route::controller(MecanicienController::class)->group(function () {
                        Route::get('mecanicien-liste-suppression', 'listeSuppression');
                        Route::get('mecanicien-excel', 'exportInfoExcel');
                        Route::get('mecanicien-csv', 'exportInfoCSV');
                        Route::get('mecanicien-pdf/{id}', 'pdf');
                        Route::get('mecanicien-all-pdf', 'pdfAll');
                        Route::get('mecanicien-restore/{id}', 'restore');
                        Route::get('mecanicien-restore-all', 'restoreAll');
                        Route::get('mecanicien-suppression-definitif/{id}', 'hdelete');
                        Route::get('mecanicien-suppression-definitif-all', 'hdeleteAll');
                        Route::get('mecanicien-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('mecanicien-all-pdf-trashed', 'pdfAllTrashed');
                    });

                /**                        reparation poubelle            */
                    Route::apiResource('reparation-poubelle', Reparation_poubelleController::class);
                    Route::controller(Reparation_poubelleController::class)->group(function () {
                        Route::get('reparation-poubelle-liste-suppression', 'listeSuppression');
                        Route::get('reparation-poubelle-excel', 'exportInfoExcel');
                        Route::get('reparation-poubelle-csv', 'exportInfoCSV');
                        Route::get('reparation-poubelle-pdf/{id}', 'pdf');
                        Route::get('reparation-poubelle-all-pdf', 'pdfAll');
                        Route::get('reparation-poubelle-restore/{id}', 'restore');
                        Route::get('reparation-poubelle-restore-all', 'restoreAll');
                        Route::get('reparation-poubelle-suppression-definitif/{id}', 'hdelete');
                        Route::get('reparation-poubelle-suppression-definitif-all', 'hdeleteAll');
                        Route::get('reparation-poubelle-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('reparation-poubelle-all-pdf-trashed', 'pdfAllTrashed');
                    });

                /**                        reparation camion               */
                    Route::apiResource('reparation-camion', Reparation_camionController::class);
                    Route::controller(Reparation_camionController::class)->group(function () {
                        Route::get('reparation-camion-liste-suppression', 'listeSuppression');
                        Route::get('reparation-camion-excel', 'exportInfoExcel');
                        Route::get('reparation-camion-csv', 'exportInfoCSV');
                        Route::get('reparation-camion-pdf/{id}', 'pdf');
                        Route::get('reparation-camion-all-pdf', 'pdfAll');
                        Route::get('reparation-camion-restore/{id}', 'restore');
                        Route::get('reparation-camion-restore-all', 'restoreAll');
                        Route::get('reparation-camion-suppression-definitif/{id}', 'hdelete');
                        Route::get('reparation-camion-suppression-definitif-all', 'hdeleteAll');
                        Route::get('reparation-camion-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('reparation-camion-all-pdf-trashed', 'pdfAllTrashed');
                    });

        /** -------------------------------------------gestion Poubelle par etablissement -----------------------------------------------*/
                /**                   zone-travail                        */
                    Route::apiResource('zone-travail', Zone_travailController::class);
                    Route::controller(Zone_travailController::class)->group(function () {
                        Route::get('zone-travail-liste-suppression', 'listeSuppression');
                        Route::get('zone-travail-excel', 'exportInfoExcel');
                        Route::get('zone-travail-csv', 'exportInfoCSV');
                        Route::get('zone-travail-pdf/{id}', 'pdf');
                        Route::get('zone-travail-all-pdf', 'pdfAll');
                        Route::get('zone-travail-restore/{id}', 'restore');
                        Route::get('zone-travail-restore-all', 'restoreAll');
                        Route::get('zone-travail-suppression-definitif/{id}', 'hdelete');
                        Route::get('zone-travail-suppression-definitif-all', 'hdeleteAll');
                        Route::get('zone-travail-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('zone-travail-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                  etablissement                      */
                    Route::apiResource('etablissement', EtablissementController::class);
                    Route::controller(EtablissementController::class)->group(function () {
                        Route::get('etablissement-liste-suppression', 'listeSuppression');
                        Route::get('etablissement-excel', 'exportInfoExcel');
                        Route::get('etablissement-csv', 'exportInfoCSV');
                        Route::get('etablissement-pdf/{id}', 'pdf');
                        Route::get('etablissement-all-pdf', 'pdfAll');
                        Route::get('etablissement-restore/{id}', 'restore');
                        Route::get('etablissement-restore-all', 'restoreAll');
                        Route::get('etablissement-suppression-definitif/{id}', 'hdelete');
                        Route::get('etablissement-suppression-definitif-all', 'hdeleteAll');
                        Route::get('etablissement-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('etablissement-all-pdf-trashed', 'pdfAllTrashed');

                    });
                /**                bloc   etablissements                      */
                    Route::apiResource('bloc-etablissement', Bloc_etablissementsController::class);
                    Route::controller(Bloc_etablissementsController::class)->group(function () {
                        Route::get('bloc-etablissement-liste-suppression', 'listeSuppression');
                        Route::get('bloc-etablissement-excel', 'exportInfoExcel');
                        Route::get('bloc-etablissement-csv', 'exportInfoCSV');
                        Route::get('bloc-etablissement-pdf/{id}', 'pdf');
                        Route::get('bloc-etablissement-all-pdf', 'pdfAll');
                        Route::get('bloc-etablissement-restore/{id}', 'restore');
                        Route::get('bloc-etablissement-restore-all', 'restoreAll');
                        Route::get('bloc-etablissement-suppression-definitif/{id}', 'hdelete');
                        Route::get('bloc-etablissement-suppression-definitif-all', 'hdeleteAll');
                        Route::get('bloc-etablissement-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('bloc-etablissement-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                etage etablissements                      */
                    Route::apiResource('etage-etablissement', Etage_etablissementsControlller::class);
                    Route::controller(Etage_etablissementsControlller::class)->group(function () {
                        Route::get('etage-etablissement-liste-suppression', 'listeSuppression');
                        Route::get('etage-etablissement-excel', 'exportInfoExcel');
                        Route::get('etage-etablissement-csv', 'exportInfoCSV');
                        Route::get('etage-etablissement-pdf/{id}', 'pdf');
                        Route::get('etage-etablissement-all-pdf', 'pdfAll');
                        Route::get('etage-etablissement-restore/{id}', 'restore');
                        Route::get('etage-etablissement-restore-all', 'restoreAll');
                        Route::get('etage-etablissement-suppression-definitif/{id}', 'hdelete');
                        Route::get('etage-etablissement-suppression-definitif-all', 'hdeleteAll');
                        Route::get('etage-etablissement-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('etage-etablissement-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                  bloc-poubelle                      */
                    Route::apiResource('bloc-poubelle', Bloc_poubelleController::class);
                    Route::controller(Bloc_poubelleController::class)->group(function () {
                        Route::get('bloc-poubelle-liste-suppression', 'listeSuppression');
                        Route::get('bloc-poubelle-excel', 'exportInfoExcel');
                        Route::get('bloc-poubelle-csv', 'exportInfoCSV');
                        Route::get('bloc-poubelle-pdf/{id}', 'pdf');
                        Route::get('bloc-poubelle-all-pdf', 'pdfAll');
                        Route::get('bloc-poubelle-restore/{id}', 'restore');
                        Route::get('bloc-poubelle-restore-all', 'restoreAll');
                        Route::get('bloc-poubelle-suppression-definitif/{id}', 'hdelete');
                        Route::get('bloc-poubelle-suppression-definitif-all', 'hdeleteAll');
                        Route::get('bloc-poubelle-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('bloc-poubelle-all-pdf-trashed', 'pdfAllTrashed');
                    });
                /**                    poubelle                        */
                    Route::apiResource('poubelle', PoubelleController::class,);
                    Route::controller(PoubelleController::class)->group(function () {
                        Route::get('poubelle-liste-suppression', 'listeSuppression');
                        Route::get('poubelle-excel', 'exportInfoExcel');
                        Route::get('poubelle-csv', 'exportInfoCSV');
                        Route::get('poubelle-pdf/{id}', 'pdf');
                        Route::get('poubelle-all-pdf', 'pdfAll');
                        Route::get('poubelle-restore/{id}', 'restore');
                        Route::get('poubelle-restore-all', 'restoreAll');
                        Route::get('poubelle-suppression-definitif/{id}', 'hdelete');
                        Route::get('poubelle-suppression-definitif-all', 'hdeleteAll');
                        Route::get('poubelle-pdf-trashed/{id}', 'pdfTrashed');
                        Route::get('poubelle-all-pdf-trashed', 'pdfAllTrashed');
                    });
        /** -------------------------------------------transport poubelle -----------------------------------------*/
            /**                       camion                            */
                Route::apiResource('camion', CamionController::class);
                Route::controller(CamionController::class)->group(function () {
                    Route::get('camion-liste-suppression', 'listeSuppression');
                    Route::get('camion-excel', 'exportInfoExcel');
                    Route::get('camion-csv', 'exportInfoCSV');
                    Route::get('camion-pdf/{id}', 'pdf');
                    Route::get('camion-all-pdf', 'pdfAll');
                    Route::get('camion-restore/{id}', 'restore');
                    Route::get('camion-restore-all', 'restoreAll');
                    Route::get('camion-suppression-definitif/{id}', 'hdelete');
                    Route::get('camion-suppression-definitif-all', 'hdeleteAll');
                    Route::get('camion-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('camion-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                        zone depot                        */
                Route::apiResource('zone-depot', Zone_depotController::class);
                Route::controller(Zone_depotController::class)->group(function () {
                    Route::get('zone-depot-liste-suppression', 'listeSuppression');
                    Route::get('zone-depot-excel', 'exportInfoExcel');
                    Route::get('zone-depot-csv', 'exportInfoCSV');
                    Route::get('zone-depot-pdf/{id}', 'pdf');
                    Route::get('zone-depot-all-pdf', 'pdfAll');
                    Route::get('zone-depot-restore/{id}', 'restore');
                    Route::get('zone-depot-restore-all', 'restoreAll');
                    Route::get('zone-depot-suppression-definitif/{id}', 'hdelete');
                    Route::get('zone-depot-suppression-definitif-all', 'hdeleteAll');
                    Route::get('zone-depot-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('zone-depot-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                       depot                            */
                Route::apiResource('depot', DepotController::class);
                Route::controller(DepotController::class)->group(function () {
                    Route::get('depot-liste-suppression', 'listeSuppression');
                    Route::get('depot-excel', 'exportInfoExcel');
                    Route::get('depot-csv', 'exportInfoCSV');
                    Route::get('depot-pdf/{id}', 'pdf');
                    Route::get('depot-all-pdf', 'pdfAll');
                    Route::get('depot-restore/{id}', 'restore');
                    Route::get('depot-restore-all', 'restoreAll');
                    Route::get('depot-suppression-definitif/{id}', 'hdelete');
                    Route::get('depot-suppression-definitif-all', 'hdeleteAll');
                    Route::get('depot-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('depot-all-pdf-trashed', 'pdfAllTrashed');
                });

        /** -------------------------------------------production poubelle -----------------------------------------*/
            /**                   Fournisseur                         */
                Route::apiResource('fournisseurs', FournisseurController::class);
                Route::controller(FournisseurController::class)->group(function () {
                    Route::get('fournisseurs-liste-suppression', 'listeSuppression');
                    Route::get('fournisseurs-excel', 'exportInfoExcel');
                    Route::get('fournisseurs-csv', 'exportInfoCSV');
                    Route::get('fournisseurs-pdf/{id}', 'pdf');
                    Route::get('fournisseurs-all-pdf', 'pdfAll');
                    Route::get('fournisseurs-restore/{id}', 'restore');
                    Route::get('fournisseurs-restore-all', 'restoreAll');
                    Route::get('fournisseurs-suppression-definitif/{id}', 'hdelete');
                    Route::get('fournisseurs-suppression-definitif-all', 'hdeleteAll');
                    Route::get('fournisseurs-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('fournisseurs-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                    Materiaux Primaires               */
                Route::apiResource('materiaux-primaires',MateriauxPrimaireController::class);
                Route::controller(MateriauxPrimaireController::class)->group(function () {
                    Route::get('materiaux-primaires-liste-suppression', 'listeSuppression');
                    Route::get('materiaux-primaires-excel', 'exportInfoExcel');
                    Route::get('materiaux-primaires-csv', 'exportInfoCSV');
                    Route::get('materiaux-primaires-pdf/{id}', 'pdf');
                    Route::get('materiaux-primaires-all-pdf', 'pdfAll');
                    Route::get('materiaux-primaires-restore/{id}', 'restore');
                    Route::get('materiaux-primaires-restore-all', 'restoreAll');
                    Route::get('materiaux-primaires-suppression-definitif/{id}', 'hdelete');
                    Route::get('materiaux-primaires-suppression-definitif-all', 'hdeleteAll');
                    Route::get('materiaux-primaires-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('materiaux-primaires-all-pdf-trashed', 'pdfAllTrashed');
                });
            /**                   Stock poubelle                  */
                Route::apiResource('stock-poubelle', StockPoubelleController::class);
                Route::controller(StockPoubelleController::class)->group(function () {
                    Route::get('stock-poubelle-liste-suppression', 'listeSuppression');
                    Route::get('stock-poubelle-excel', 'exportInfoExcel');
                    Route::get('stock-poubelle-csv', 'exportInfoCSV');
                    Route::get('stock-poubelle-pdf/{id}', 'pdf');
                    Route::get('stock-poubelle-all-pdf', 'pdfAll');
                    Route::get('stock-poubelle-restore/{id}', 'restore');
                    Route::get('stock-poubelle-restore-all', 'restoreAll');
                    Route::get('stock-poubelle-suppression-definitif/{id}', 'hdelete');
                    Route::get('stock-poubelle-suppression-definitif-all', 'hdeleteAll');
                    Route::get('stock-poubelle-pdf-trashed/{id}', 'pdfTrashed');
                    Route::get('stock-poubelle-all-pdf-trashed', 'pdfAllTrashed');
                });
                Route::post('/update-stock-image/{id}', [StockPoubelleController::class, 'updateStockImage']);

/**                               fin crud                                    */

/**                               debut Rechecher                             */
        Route::get('/bloc-etablissement-liste/{etab}',[RechercheGestionnaireController::class,"BlocEtablissementListe"]);
        Route::get('/etage-etablissement-liste/{etab}/{bloc_etab}',[RechercheGestionnaireController::class,"EtageEtablissementListe"]);
        Route::get('/bloc-poubelle-liste/{etab}/{bloc_etab}/{etage}',[RechercheGestionnaireController::class,"BlocPoubelleListe"]);
/**                               fin Rechecher                               */

        Route::get('/situation-financiere-gestionnaire-jour', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireJour']);
        Route::get('/situation-financiere-gestionnaire-mensuel', [SituationFinanciereController::class, 'SituationFinanciereGestionnaireMensuel']);


    Route::get('/somme-dechets-depot-par-mois', [SommeDechetController::class, 'sommeDechetsDepotparMois']);
    Route::get('/somme-dechet-annees', [SommeDechetController::class, 'sommeDechetAnnees']);
    Route::get('/somme-dechets-vendus', [SommeDechetController::class, 'sommeDechetsVendus']);
/** -------------  **************                  **************************  ------------------**/
    Route::group(['prefix' => 'auth-gestionnaire'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::group(['middleware' => 'auth:gestionnaire'], function() {
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


