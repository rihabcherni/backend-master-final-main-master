<?php

use App\Http\Controllers\API\Dashboard\DashboardEtablissementController;
use App\Http\Controllers\API\Dashboard\RechercheController;
use App\Http\Controllers\API\GestionCompte\ResponableEtablissementResponsableController;
use App\Http\Controllers\API\PlanningController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\Bloc_etablissementsController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\BlocPoubellesController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\EtageEtablissementsController;
use App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable\PoubelleController;
use App\Http\Controllers\API\ResponsableEtablissement\ResponsableMapController;
use App\Http\Controllers\API\ResponsableEtablissement\ResponsableController;
use App\Http\Controllers\API\ResponsableEtablissement\SituationFinanciereController;
use App\Http\Controllers\Auth\ResponsableEtablissement\AuthResponsableEtablissementController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
    Route::get('/situation-financiere-responsable-jour', [SituationFinanciereController::class, 'SituationFinanciereResponsableJour']);
    Route::get('/situation-financiere-responsable-mensuel', [SituationFinanciereController::class, 'SituationFinanciereResponsableMensuel']);
    Route::get('/etablissement-responsable',[RechercheController::class, 'etablissementResponsable']);

    Route::apiResource('add-resp-etablissement', ResponableEtablissementResponsableController::class);
    Route::group(['prefix' =>'auth-responsable-etablissement'], function () {
        Route::group(['middleware'=>['auth:sanctum']], function() {
            Route::get('/planning-responsable', [PlanningController::class, 'planningResponsable']);
                    Route::group(['middleware' => 'auth:responsable_etablissement'], function() {
                        Route::post('/modifier-responsable-etablissement-password',[AuthResponsableEtablissementController::class,'modifierPasswordResponsableEtablissement']);
                        Route::post('/send',[AuthResponsableEtablissementController::class,'send']);
                        Route::post('/sendImage',[AuthResponsableEtablissementController::class,'sendImage']);
                        Route::post('/destroyImage',[AuthResponsableEtablissementController::class,'destroyImage']);
                        Route::get('/panne-etablissement-poubelle-responsable',[ResponsableController::class, 'panneetablissementPoubelle']);

                        Route::get('/bloc-etablissement-resp',[ResponsableController::class,'BlocEtablissementResponsable']);

                        Route::get('/dashboard-etablissement', [DashboardEtablissementController::class, 'dashboard_etablissement']);
                        Route::get('/poubelle-plus-remplis-etablissement', [DashboardEtablissementController::class, 'PoubellePlusRemplis']);


                        Route::post('/getConversations' , [ConversationController::class , 'index']);
                        Route::post('/conversation' , [ConversationController::class , 'store']);
                        Route::post('/conversation/read' , [ConversationController::class , 'makeConversationAsReaded']);
                        Route::post('/message' , [MessageController::class , 'store']);

                        Route::get('/responsable-map', [ResponsableMapController::class, 'ResponsableMap']);

                        Route::apiResource('bloc-etablissement-responsable', Bloc_etablissementsController::class);
                                 /**                etage etablissements                      */
                        Route::apiResource('etage-etablissement-responsable', EtageEtablissementsController::class);

                                /**                  bloc-poubelle                      */
                        Route::apiResource('bloc-poubelle-responsable', BlocPoubellesController::class);
                                /**                    poubelle                        */
                        Route::apiResource('poubelle-responsable', PoubelleController::class);

                    });
                        Route::get('/checkingAuthResponsable' , function(){
                            return response()->json(['message'=>'Responsable etablissement vous avez connecté','status'=>200],200);
                        });
        });
    });
