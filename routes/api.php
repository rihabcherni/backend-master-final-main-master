<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Globale\SommeDechetController;
use App\Http\Controllers\Globale\RechercheController;
use App\Http\Controllers\Globale\RegionController;
use App\Http\Controllers\Auth\Ouvrier\AuthOuvrierController;
use App\Http\Controllers\Authentification\ForgotPasswordController;
use App\Http\Controllers\Gestionnaire\TableCrud\ViderPoubelleGestionnaireController;
use App\Http\Controllers\Authentification\LoginController;
use App\Http\Controllers\Authentification\LogoutController;
use App\Http\Controllers\Authentification\ModifierPasswordController;
use App\Http\Controllers\Authentification\ModifierProfileController;
use App\Http\Controllers\Authentification\ProfileController;
use App\Http\Controllers\Authentification\QrloginController;
use App\Http\Controllers\Globale\ViderPoubellesController;

/********************               Authentification           ****************************** */
    Route::post('/login', [LoginController::class,'login']);
    Route::post('/logout', [LogoutController::class,'logout']);
    Route::post('/modifier-password', [ModifierPasswordController::class,'modifierPassword']);
    Route::post('/modifier-profile', [ModifierProfileController::class,'modifierProfile']);

    Route::post('/modifier-photo', [ModifierProfileController::class,'updatePhoto']);
    Route::get('/profile', [ProfileController::class,'profile']);
    Route::post('/qrlogin/{qrcode}',[QrloginController::class,'qrlogin']);

    Route::post('/oublier-password-verification-code', [ForgotPasswordController::class,'forgotPasswordVerificationCode']);
    Route::post('/oublier-password-update', [ForgotPasswordController::class,'updatePasswordOublier']);



























    /** -------------  **************          debut recherche    ************************** ------------------**/
            Route::get('/recherche-etablissement-zone-travail-nom/{nom_zone}', [RechercheController::class, 'rechercheEtablissementNomZone']);
            Route::get('/recherche-etablissement-zone-travail-id/{zone_travail_id}', [RechercheController::class, 'rechercheEtablissementIDZone']);

            Route::get('/recherche-zone-travail/{region}', [RechercheController::class, 'rechercheZoneTravail']);

            Route::get('/recherche-reparateur-poubelle/{adresse}', [RechercheController::class, 'rechercheReparateurPoubelleAdresse']);

            Route::get('/recherche-bloc-poubelle/{etablissement}/{nom_bloc_etab}/{nom_etage}/{id_bloc_poubelle}', [RechercheController::class, 'rechercheBlocPoubelleEtab']);

            Route::get('/poubelle-bloc-poubelle-id/{bloc_poubelle_id}', [RechercheController::class, 'rechercheBlocPoubelleId']);
            Route::get('/poubelle/searcheType/{type}', [RechercheController::class, 'searcheType']);

            Route::get('/camion/searchMatricule/{matricule}', [RechercheController::class, 'searchMatricule']);

    /** -------------  **************         fin recherche      **************************  ------------------**/


/** ---------------------------------------------- debut Dashboard ----------------------------------------------------*/
            /** -------------  **************         debut somme      **************************  ------------------**/
                    Route::get('/somme-total-stock-dechet-zone-depot', [SommeDechetController::class, 'SommeDechetZoneDepot']);
                    // Route::get('/somme-total-dechet-etablissement/{zone_travail_id}', [SommeDechetController::class, 'SommeDechetBlocEtablissement']);

                    Route::get('/prixdechets', [SommeDechetController::class, 'PrixDechets']);

                /** -------------  **************         fin somme      **************************  ------------------**/
            /** -------------  **************         fin dashborad gestionnaire        **************************  ------------------**/


            /** -------------  **************         debut map      **************************  ------------------**/
                Route::get('/region-map', [RegionController::class, 'RegionMap']);
            /** -------------  **************         fin map      **************************  ------------------**/

/** ----------------------------------------------fin Dashboard ----------------------------------------------------*/

            /** -------------  **************         debut authentifiaction      **************************  ------------------**/

                Route::post('/send-ouvrier',[AuthOuvrierController::class,'send']);

            /** -------------  **************         fin authentifiaction      **************************  ------------------**/

                Route::get('/google-map', [RegionController::class, 'GoogleMap']);
                Route::get('/google-map/{id}', [RegionController::class, 'GoogleMapId']);
                Route::get('/google-map-camion', [RegionController::class, 'GoogleMapCamion']);
                Route::get('/google-map-camion/{id}', [RegionController::class, 'GoogleMapCamionId']);



                Route::get('/historique-vider-poubelle-responsable', [ViderPoubellesController::class,'HistoriqueViderResponsable']);
                Route::get('/historique-vider-poubelle-gestionnaire', [ViderPoubellesController::class,'HistoriqueViderGestionnaire']);

                Route::get('/historique-vider-poubelle-gestionnaire-csv', [ViderPoubelleGestionnaireController::class,'exportInfoViderPoubelleCSV']);
                Route::get('/historique-vider-poubelle-gestionnaire-excel', [ViderPoubelleGestionnaireController::class,'exportInfoViderPoubelleExcel']);
                Route::get('/historique-vider-poubelle-gestionnaire-all-pdf', [ViderPoubelleGestionnaireController::class,'pdfAllViderPoubelle']);
                Route::get('/historique-vider-poubelle-gestionnaire-pdf/{id}', [ViderPoubelleGestionnaireController::class,'pdfViderPoubelle']);

                Route::get('/situation-financiere-mois', [ViderPoubellesController::class,'SituationFianciereMoisResponsable']);

                Route::get('/situation-financiere-mois-gestionnaire', [ViderPoubellesController::class,'SituationFianciereMoisGestionnaire']);

               /**                     RescooL Revenu                    */
                Route::get('/revenu-reschool-mois', [ViderPoubellesController::class,'revenuGestionnaire']);
                Route::get('/revenu-reschool-mois-filter/{etablissement}', [ViderPoubellesController::class,'GestFiltrageRevenuReschool']);
               /**                     Responsable Revenu                    */
               Route::get('/revenu-etab-mois', [ViderPoubellesController::class,'revenuEtablissementGestionnaire']);
               Route::get('/revenu-etab-mois-filter/{etablissement}', [ViderPoubellesController::class,'GestFiltrageRevenuEtablissement']);

               /**                     Totale Revenu                    */
                Route::get('/revenu-totale-mois', [ViderPoubellesController::class,'revenuTotaleGest']);
                Route::get('/revenu-totale-mois-filter/{etablissement}', [ViderPoubellesController::class,'RevenuTotaleFiltrerEtablissement']);


               /**                     quantite                     */

                Route::get('/gest-quantite-collecte-mois', [ViderPoubellesController::class,'quantiteCollecteMoisGestionnaire']);

                Route::get('/gest-quantite-collecte-etablissement-mois/{etablissement}', [ViderPoubellesController::class,'quantiteCollecteEtablissementGestionnaire']);


                Route::get('/EtablissementListe', [ViderPoubellesController::class,'EtablissementListe']);


