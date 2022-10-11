<?php
namespace App\Http\Controllers\Globale;

use App\Http\Resources\ViderPoubelle;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Camion;
use App\Models\Dechet;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;
use App\Models\Poubelle;
use App\Models\Vider_poubelle;
use App\Models\Zone_depot;
use Carbon\Carbon;
class ViderPoubellesController extends Controller{
    /**                                 responsable                           */
        public function  HistoriqueViderResponsable(){
            $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
            $etab= Etablissement::where('id', $etab_id)->first() ;
            $historique= Vider_poubelle::orderBy('date_depot', 'desc')->get();
            $a=[];
            foreach($historique as $h){
                $poubelle= Poubelle::where('id',$h->poubelle_id)->first();
                $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
                $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
                $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
                $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
                $h->nom_poubelle=$poubelle->nom;
                $h->type=$poubelle->type;
                $quantite=0;
                if($poubelle->type==="plastique"){ $quantite=$h->quantite_depose_plastique;}
                else if($poubelle->type==="papier"){$quantite=$h->quantite_depose_papier;}
                else if($poubelle->type==="composte"){$quantite=$h->quantite_depose_composte;}
                else if($poubelle->type==="canette"){$quantite=$h->quantite_depose_canette;}
                $h->quantite=$quantite;
                $h->etablissement=$etablissement->nom_etablissement;
            array_push($a,$h);
            }
            $poubelle_etab=[];
            foreach ($a as $pb){
                if($pb->etablissement ===$etab->nom_etablissement){
                array_push($poubelle_etab, $pb);
                }
            }
            return ViderPoubelle::collection($poubelle_etab) ;

        }
        public function  HistoriqueViderGestionnaire(){
            $historique= Vider_poubelle::orderBy('date_depot', 'desc')->get();
            // $a=[];
            // foreach($historique as $h){
            //     $poubelle= Poubelle::where('id',$h->poubelle_id)->first();
            //     $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
            //     $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
            //     $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
            //     $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
            //     $h->nom_poubelle=$poubelle->nom;
            //     $h->type=$poubelle->type;
            //     $quantite=0;
            //     if($poubelle->type==="plastique"){
            //         $quantite=$h->quantite_depose_plastique;
            //     }else if($poubelle->type==="papier"){
            //         $quantite=$h->quantite_depose_papier;
            //     }else if($poubelle->type==="composte"){
            //         $quantite=$h->quantite_depose_composte;
            //     }else if($poubelle->type==="canette"){
            //         $quantite=$h->quantite_depose_canette;
            //     }
            //     $h->quantite=$quantite;
            //     $h->etablissement=$etablissement->nom_etablissement;
            // array_push($a,$h);
            // }
            return ViderPoubelle::collection($historique) ;
            // return $a ;
        }

        public function SituationFianciereMoisResponsable(){
            $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
            $etab= Etablissement::where('id', $etab_id)->first() ;
            $historique= Vider_poubelle::get();
            $a=[];
            foreach($historique as $h){
                $poubelle= Poubelle::where('id',$h->poubelle_id)->first();
                $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
                $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
                $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
                $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
                $h->nom_poubelle=$poubelle->nom;
                $h->type=$poubelle->type;
                $h->bloc_poubelle_id=$bloc_poubelle->id;
                $h->etage=$etage->nom_etage_etablissement;
                $h->bloc_etablissement=$bloc_etabl->nom_bloc_etablissement;
                $h->etablissement=$etablissement->nom_etablissement;
            array_push($a,$h);
            }
            $poubelle_etab=[];
            foreach ($a as $pb){
                if($pb->etablissement ===$etab->nom_etablissement){
                array_push($poubelle_etab, $pb);
                }
            }
            $an=[];
            foreach($poubelle_etab as $e){
            $date = Carbon::createFromFormat('Y-m-d H:i:s', $e->date_depot)->format('Y');
            array_push($an ,$date);
            }
            $y=array_map('intval',array_unique($an));
            $year=[];
            foreach ($y as $ye){
            array_push($year, ["year"=>$ye]);
            }
            $id=[];
            foreach($poubelle_etab as $pe){ array_push($id, $pe->poubelle_id);}
            $somme = Vider_poubelle::whereIn('poubelle_id', $id)->selectRaw('year(date_depot) as year, month(date_depot) as month,
            ifnull(sum(quantite_depose_plastique),0) as quantite_depose_plastique,
            ifnull(sum(quantite_depose_papier),0) as quantite_depose_papier,ifnull(sum(quantite_depose_composte),0) as quantite_depose_composte,
            ifnull(sum(quantite_depose_canette),0)  as quantite_depose_canette')->groupBy('year','month')->orderByRaw('min(date_depot) desc')->get();
            $prix_plastique= Dechet::where("type_dechet","plastique")->value("prix_unitaire");
            $prix_papier= Dechet::where("type_dechet","papier")->value("prix_unitaire");
            $prix_composte= Dechet::where("type_dechet","composte")->value("prix_unitaire");
            $prix_canette= Dechet::where("type_dechet","canette")->value("prix_unitaire");

            $mat_plastique=[]; $mat_papier=[]; $mat_composte=[]; $mat_canette=[];
            $mat_plastique_revenu=[]; $mat_papier_revenu=[]; $mat_composte_revenu=[]; $mat_canette_revenu=[];
            $mat_plastique_revenu_gestionnaire=[]; $mat_papier_revenu_gestionnaire=[]; $mat_composte_revenu_gestionnaire=[]; $mat_canette_revenu_gestionnaire=[];
            $mat_plastique_revenu_responsable=[]; $mat_papier_revenu_responsable=[]; $mat_composte_revenu_responsable=[]; $mat_canette_revenu_responsable=[];
            for ($j=0;$j<count($year);$j++) {
                $plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
                $papier= [0,0,0,0,0,0,0,0,0,0,0,0];
                $composte= [0,0,0,0,0,0,0,0,0,0,0,0];
                $canette= [0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                for($i=12;$i>=1;$i--){
                    for ($t=0;$t<$somme->count();$t++){
                        if($somme[$t]['year']===$year[$j]['year']){
                            if( $somme[$t]['month'] ===$i){
                                $plastique[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique'];
                                $plastique_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique']*$prix_plastique;
                                $plastique_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $plastique_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $papier[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier'];
                                $papier_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier']*$prix_papier;
                                $papier_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $papier_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $composte[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte'];
                                $composte_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte']*$prix_composte;
                                $composte_revenu_gestionnaire[$somme[$t]['month']-1]= round((($somme[$t]['quantite_depose_composte']*$prix_composte) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $composte_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_composte']*$prix_composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $canette[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette'];
                                $canette_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette']*$prix_canette;
                                $canette_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $canette_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                            }
                        }
                    }
                }
                array_push($mat_plastique, $plastique);
                array_push($mat_papier, $papier);
                array_push($mat_composte, $composte);
                array_push($mat_canette, $canette);

                array_push($mat_plastique_revenu, $plastique_revenu);
                array_push($mat_papier_revenu, $papier_revenu);
                array_push($mat_composte_revenu, $composte_revenu);
                array_push($mat_canette_revenu, $canette_revenu);

                array_push($mat_plastique_revenu_gestionnaire, $plastique_revenu_gestionnaire);
                array_push($mat_papier_revenu_gestionnaire, $papier_revenu_gestionnaire);
                array_push($mat_composte_revenu_gestionnaire, $composte_revenu_gestionnaire);
                array_push($mat_canette_revenu_gestionnaire, $canette_revenu_gestionnaire);

                array_push($mat_plastique_revenu_responsable, $plastique_revenu_responsable);
                array_push($mat_papier_revenu_responsable, $papier_revenu_responsable);
                array_push($mat_composte_revenu_responsable, $composte_revenu_responsable);
                array_push($mat_canette_revenu_responsable, $canette_revenu_responsable);
            }
            $ann=[];
            for ($j=0;$j<count($year);$j++) {
                array_push($ann,$year[$j]['year']);
            }
            $myArray = [

                'annee'=>$ann,

                'quantite'=>[
                    'plastique'=>$mat_plastique,
                    'papier'=>$mat_papier,
                    'composte'=>$mat_composte,
                    'canette'=>$mat_canette,
                ],
                'revenu_total'=>[
                    'plastique'=>$mat_plastique_revenu,
                    'papier'=>$mat_papier_revenu,
                    'composte'=>$mat_composte_revenu,
                    'canette'=>$mat_canette_revenu,
                ],
                'revenu_responsable'=>[
                    'plastique'=>$mat_plastique_revenu_responsable,
                    'papier'=>$mat_papier_revenu_responsable,
                    'composte'=>$mat_composte_revenu_responsable,
                    'canette'=>$mat_canette_revenu_responsable,
                ],
                'revenu_gestionnaire'=>[
                    'plastique'=>$mat_plastique_revenu_gestionnaire,
                    'papier'=>$mat_papier_revenu_gestionnaire,
                    'composte'=>$mat_composte_revenu_gestionnaire,
                    'canette'=>$mat_canette_revenu_gestionnaire,
                ],
            ];
            return $myArray;
        }
        public function quantiteCollecteMoisResponsable(){
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisResponsable();
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $quantite=   $data_dashboard_etablissement_controller["quantite"];
            $plastique=   $quantite["plastique"];
            $papier=   $quantite["papier"];
            $composte=   $quantite["composte"];
            $canette=   $quantite["canette"];
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
        public function revenu_etablissement_responsable(){
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisResponsable();
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $quantite=   $data_dashboard_etablissement_controller["revenu_responsable"];
            $plastique=   $quantite["plastique"];
            $papier=   $quantite["papier"];
            $composte=   $quantite["composte"];
            $canette=   $quantite["canette"];
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
        public function QuantiteEtablissementResponsableAnnee(){
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisResponsable();
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $quantite=   $data_dashboard_etablissement_controller["quantite"];
            $plastique=[];
            foreach($quantite["plastique"] as $p){
                $pl=   array_sum($p);
                array_push($plastique, $pl);
            }
            $papier=[];
            foreach($quantite["papier"] as $pa){
                $pap=   array_sum($pa);
                array_push($papier, $pap);
            }
            $composte=[];
            foreach($quantite["composte"] as $com){
                $co=   array_sum($com);
                array_push($composte, $co);
            }
            $canette=[];
            foreach($quantite["canette"] as $ca){
                $can=   array_sum($ca);
                array_push($canette, $can);
            }
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
        public function revenuEtablissementResponsableAnnee(){
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisResponsable();
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $revenu=   $data_dashboard_etablissement_controller["revenu_responsable"];
            $plastique=[];
            foreach($revenu["plastique"] as $p){
                $pl=   array_sum($p);
                array_push($plastique, $pl);
            }
            $papier=[];
            foreach($revenu["papier"] as $pa){
                $pap=   array_sum($pa);
                array_push($papier, $pap);
            }
            $composte=[];
            foreach($revenu["composte"] as $com){
                $co=   array_sum($com);
                array_push($composte, $co);
            }
            $canette=[];
            foreach($revenu["canette"] as $ca){
                $can=   array_sum($ca);
                array_push($canette, $can);
            }
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
   /**                                 gestionnaire                           */
        public function SituationFianciereMoisGestionnaire(){
            $historique= Vider_poubelle::get();
            $a=[];
            foreach($historique as $h){
                $poubelle= Poubelle::where('id',$h->poubelle_id)->first();
                $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
                $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
                $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
                $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
                $h->nom_poubelle=$poubelle->nom;
                $h->type=$poubelle->type;
                $h->bloc_poubelle_id=$bloc_poubelle->id;
                $h->etage=$etage->nom_etage_etablissement;
                $h->bloc_etablissement=$bloc_etabl->nom_bloc_etablissement;
                $h->etablissement=$etablissement->nom_etablissement;
                array_push($a,$h);
            }
            $an=[];
            foreach($a as $e){
                $date = Carbon::createFromFormat('Y-m-d H:i:s', $e->date_depot)->format('Y');
                array_push($an ,$date);
            }
            $y=array_map('intval',array_unique($an));
            $year=[];
            foreach ($y as $ye){
               array_push($year, ["year"=>$ye]);
            }
            $id=[];
            foreach($a as $pe){ array_push($id, $pe->poubelle_id);}
            $somme = Vider_poubelle::whereIn('poubelle_id', $id)->selectRaw('year(date_depot) as year, month(date_depot) as month,
            ifnull(sum(quantite_depose_plastique),0) as quantite_depose_plastique,
            ifnull(sum(quantite_depose_papier),0) as quantite_depose_papier,ifnull(sum(quantite_depose_composte),0) as quantite_depose_composte,
            ifnull(sum(quantite_depose_canette),0)  as quantite_depose_canette')->groupBy('year','month')->orderByRaw('min(date_depot) desc')->get();
            $prix_plastique= Dechet::where("type_dechet","plastique")->value("prix_unitaire");
            $prix_papier= Dechet::where("type_dechet","papier")->value("prix_unitaire");
            $prix_composte= Dechet::where("type_dechet","composte")->value("prix_unitaire");
            $prix_canette= Dechet::where("type_dechet","canette")->value("prix_unitaire");

            $mat_plastique=[]; $mat_papier=[]; $mat_composte=[]; $mat_canette=[];
            $mat_plastique_revenu=[]; $mat_papier_revenu=[]; $mat_composte_revenu=[]; $mat_canette_revenu=[];
            $mat_plastique_revenu_gestionnaire=[]; $mat_papier_revenu_gestionnaire=[]; $mat_composte_revenu_gestionnaire=[]; $mat_canette_revenu_gestionnaire=[];
            $mat_plastique_revenu_responsable=[]; $mat_papier_revenu_responsable=[]; $mat_composte_revenu_responsable=[]; $mat_canette_revenu_responsable=[];
            for ($j=0;$j<count($year);$j++) {
                $plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
                $papier= [0,0,0,0,0,0,0,0,0,0,0,0];
                $composte= [0,0,0,0,0,0,0,0,0,0,0,0];
                $canette= [0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];

                $plastique_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $papier_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $composte_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                $canette_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                for($i=12;$i>=1;$i--){
                    for ($t=0;$t<$somme->count();$t++){
                        if($somme[$t]['year']===$year[$j]['year']){
                            if( $somme[$t]['month'] ===$i){
                                $plastique[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique'];
                                $plastique_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique']*$prix_plastique;
                                $plastique_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $plastique_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $papier[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier'];
                                $papier_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier']*$prix_papier;
                                $papier_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $papier_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $composte[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte'];
                                $composte_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte']*$prix_composte;
                                $composte_revenu_gestionnaire[$somme[$t]['month']-1]= round((($somme[$t]['quantite_depose_composte']*$prix_composte) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $composte_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_composte']*$prix_composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                $canette[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette'];
                                $canette_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette']*$prix_canette;
                                $canette_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                $canette_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                            }
                        }
                    }
                }
                array_push($mat_plastique, $plastique);
                array_push($mat_papier, $papier);
                array_push($mat_composte, $composte);
                array_push($mat_canette, $canette);

                array_push($mat_plastique_revenu, $plastique_revenu);
                array_push($mat_papier_revenu, $papier_revenu);
                array_push($mat_composte_revenu, $composte_revenu);
                array_push($mat_canette_revenu, $canette_revenu);

                array_push($mat_plastique_revenu_gestionnaire, $plastique_revenu_gestionnaire);
                array_push($mat_papier_revenu_gestionnaire, $papier_revenu_gestionnaire);
                array_push($mat_composte_revenu_gestionnaire, $composte_revenu_gestionnaire);
                array_push($mat_canette_revenu_gestionnaire, $canette_revenu_gestionnaire);

                array_push($mat_plastique_revenu_responsable, $plastique_revenu_responsable);
                array_push($mat_papier_revenu_responsable, $papier_revenu_responsable);
                array_push($mat_composte_revenu_responsable, $composte_revenu_responsable);
                array_push($mat_canette_revenu_responsable, $canette_revenu_responsable);
            }
            $ann=[];
            for ($j=0;$j<count($year);$j++) {
                array_push($ann,$year[$j]['year']);
            }
            $myArray = [

                'annee'=>$ann,

                'quantite'=>[
                    'plastique'=>$mat_plastique,
                    'papier'=>$mat_papier,
                    'composte'=>$mat_composte,
                    'canette'=>$mat_canette,
                ],
                'revenu_total'=>[
                    'plastique'=>$mat_plastique_revenu,
                    'papier'=>$mat_papier_revenu,
                    'composte'=>$mat_composte_revenu,
                    'canette'=>$mat_canette_revenu,
                ],
                'revenu_responsable'=>[
                    'plastique'=>$mat_plastique_revenu_responsable,
                    'papier'=>$mat_papier_revenu_responsable,
                    'composte'=>$mat_composte_revenu_responsable,
                    'canette'=>$mat_canette_revenu_responsable,
                ],
                'revenu_gestionnaire'=>[
                    'plastique'=>$mat_plastique_revenu_gestionnaire,
                    'papier'=>$mat_papier_revenu_gestionnaire,
                    'composte'=>$mat_composte_revenu_gestionnaire,
                    'canette'=>$mat_canette_revenu_gestionnaire,
                ],
            ];
            return $myArray;
        }
        public function FiltrageEtablissementGestionnaire($etab){
            if($etab !== null){
                $historique= Vider_poubelle::get();
                $a=[];
                foreach($historique as $h){
                    $poubelle= Poubelle::where('id',$h->poubelle_id)->first();
                    $bloc_poubelle= Bloc_poubelle::where('id',$poubelle->bloc_poubelle_id)->first();
                    $etage= Etage_etablissement::where('id',$bloc_poubelle->etage_etablissement_id)->first();
                    $bloc_etabl= Bloc_etablissement::where('id',$etage->bloc_etablissement_id)->first();
                    $etablissement= Etablissement::where('id',$bloc_etabl->etablissement_id)->first();
                    $h->nom_poubelle=$poubelle->nom;
                    $h->type=$poubelle->type;
                    $h->bloc_poubelle_id=$bloc_poubelle->id;
                    $h->etage=$etage->nom_etage_etablissement;
                    $h->bloc_etablissement=$bloc_etabl->nom_bloc_etablissement;
                    $h->etablissement=$etablissement->nom_etablissement;
                array_push($a,$h);
                }
                $poubelle_etab=[];
                foreach ($a as $pb){
                  if($pb->etablissement ===$etab->nom_etablissement){ array_push($poubelle_etab, $pb); }
                }
                $an=[];
                foreach($poubelle_etab as $e){
                    $date = Carbon::createFromFormat('Y-m-d H:i:s', $e->date_depot)->format('Y');
                    array_push($an ,$date);
                }
                $y=array_map('intval',array_unique($an));
                $year=[];
                foreach ($y as $ye){array_push($year, ["year"=>$ye]); }
                $id=[];
                foreach($poubelle_etab as $pe){ array_push($id, $pe->poubelle_id);}
                $somme = Vider_poubelle::whereIn('poubelle_id', $id)->selectRaw('year(date_depot) as year, month(date_depot) as month,
                ifnull(sum(quantite_depose_plastique),0) as quantite_depose_plastique,
                ifnull(sum(quantite_depose_papier),0) as quantite_depose_papier,ifnull(sum(quantite_depose_composte),0) as quantite_depose_composte,
                ifnull(sum(quantite_depose_canette),0)  as quantite_depose_canette')->groupBy('year','month')->orderByRaw('min(date_depot) desc')->get();
                $prix_plastique= Dechet::where("type_dechet","plastique")->value("prix_unitaire");
                $prix_papier= Dechet::where("type_dechet","papier")->value("prix_unitaire");
                $prix_composte= Dechet::where("type_dechet","composte")->value("prix_unitaire");
                $prix_canette= Dechet::where("type_dechet","canette")->value("prix_unitaire");

                $mat_plastique=[]; $mat_papier=[]; $mat_composte=[]; $mat_canette=[];
                $mat_plastique_revenu=[]; $mat_papier_revenu=[]; $mat_composte_revenu=[]; $mat_canette_revenu=[];
                $mat_plastique_revenu_gestionnaire=[]; $mat_papier_revenu_gestionnaire=[]; $mat_composte_revenu_gestionnaire=[]; $mat_canette_revenu_gestionnaire=[];
                $mat_plastique_revenu_responsable=[]; $mat_papier_revenu_responsable=[]; $mat_composte_revenu_responsable=[]; $mat_canette_revenu_responsable=[];
                for ($j=0;$j<count($year);$j++) {
                    $plastique= [0,0,0,0,0,0,0,0,0,0,0,0];
                    $papier= [0,0,0,0,0,0,0,0,0,0,0,0];
                    $composte= [0,0,0,0,0,0,0,0,0,0,0,0];
                    $canette= [0,0,0,0,0,0,0,0,0,0,0,0];

                    $plastique_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $papier_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $composte_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $canette_revenu=[0,0,0,0,0,0,0,0,0,0,0,0];

                    $plastique_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $papier_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $composte_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $canette_revenu_gestionnaire=[0,0,0,0,0,0,0,0,0,0,0,0];

                    $plastique_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $papier_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $composte_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                    $canette_revenu_responsable=[0,0,0,0,0,0,0,0,0,0,0,0];
                    for($i=12;$i>=1;$i--){
                        for ($t=0;$t<$somme->count();$t++){
                            if($somme[$t]['year']===$year[$j]['year']){
                                if( $somme[$t]['month'] ===$i){
                                    $plastique[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique'];
                                    $plastique_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_plastique']*$prix_plastique;
                                    $plastique_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                    $plastique_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_plastique']*$prix_plastique) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                    $papier[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier'];
                                    $papier_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_papier']*$prix_papier;
                                    $papier_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                    $papier_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_papier']*$prix_papier) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                    $composte[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte'];
                                    $composte_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_composte']*$prix_composte;
                                    $composte_revenu_gestionnaire[$somme[$t]['month']-1]= round((($somme[$t]['quantite_depose_composte']*$prix_composte) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                    $composte_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_composte']*$prix_composte) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;

                                    $canette[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette'];
                                    $canette_revenu[$somme[$t]['month']-1]=$somme[$t]['quantite_depose_canette']*$prix_canette;
                                    $canette_revenu_gestionnaire[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *(100-config('global.pourcentage_revenu_responsable'))) /100 * 1000)/1000 ;
                                    $canette_revenu_responsable[$somme[$t]['month']-1]=round((($somme[$t]['quantite_depose_canette']*$prix_canette) *config('global.pourcentage_revenu_responsable')) /100* 1000)/1000;
                                }
                            }
                        }
                    }
                    array_push($mat_plastique, $plastique);
                    array_push($mat_papier, $papier);
                    array_push($mat_composte, $composte);
                    array_push($mat_canette, $canette);

                    array_push($mat_plastique_revenu, $plastique_revenu);
                    array_push($mat_papier_revenu, $papier_revenu);
                    array_push($mat_composte_revenu, $composte_revenu);
                    array_push($mat_canette_revenu, $canette_revenu);

                    array_push($mat_plastique_revenu_gestionnaire, $plastique_revenu_gestionnaire);
                    array_push($mat_papier_revenu_gestionnaire, $papier_revenu_gestionnaire);
                    array_push($mat_composte_revenu_gestionnaire, $composte_revenu_gestionnaire);
                    array_push($mat_canette_revenu_gestionnaire, $canette_revenu_gestionnaire);

                    array_push($mat_plastique_revenu_responsable, $plastique_revenu_responsable);
                    array_push($mat_papier_revenu_responsable, $papier_revenu_responsable);
                    array_push($mat_composte_revenu_responsable, $composte_revenu_responsable);
                    array_push($mat_canette_revenu_responsable, $canette_revenu_responsable);
                }
                $ann=[];
                for ($j=0;$j<count($year);$j++) { array_push($ann,$year[$j]['year']); }
                $myArray = [
                    'annee'=>$ann,
                    'quantite'=>[ 'plastique'=>$mat_plastique, 'papier'=>$mat_papier, 'composte'=>$mat_composte, 'canette'=>$mat_canette],
                    'revenu_total'=>[
                        'plastique'=>$mat_plastique_revenu,
                        'papier'=>$mat_papier_revenu,
                        'composte'=>$mat_composte_revenu,
                        'canette'=>$mat_canette_revenu,
                    ],
                    'revenu_responsable'=>[
                        'plastique'=>$mat_plastique_revenu_responsable,
                        'papier'=>$mat_papier_revenu_responsable,
                        'composte'=>$mat_composte_revenu_responsable,
                        'canette'=>$mat_canette_revenu_responsable,
                    ],
                    'revenu_gestionnaire'=>[
                        'plastique'=>$mat_plastique_revenu_gestionnaire,
                        'papier'=>$mat_papier_revenu_gestionnaire,
                        'composte'=>$mat_composte_revenu_gestionnaire,
                        'canette'=>$mat_canette_revenu_gestionnaire,
                    ],
                ];
                return $myArray;
            }else{return "vide";}
        }
        /*      Revenu Gestionnaire      */
            public function revenuGestionnaire(){
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisGestionnaire();
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $revenu=   $data_dashboard_etablissement_controller["revenu_gestionnaire"];
                $plastique=   $revenu["plastique"];
                $papier=   $revenu["papier"];
                $composte=   $revenu["composte"];
                $canette=   $revenu["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
            public function GestFiltrageRevenuReschool($etablissement){
                $etab= Etablissement::where('nom_etablissement', $etablissement)->first() ;
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->FiltrageEtablissementGestionnaire($etab);
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $revenu=   $data_dashboard_etablissement_controller["revenu_gestionnaire"];
                $plastique=   $revenu["plastique"];
                $papier=   $revenu["papier"];
                $composte=   $revenu["composte"];
                $canette=   $revenu["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
        /*      Revenu Totale      */
            public function revenuTotaleGest(){
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisGestionnaire();
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $quantite=   $data_dashboard_etablissement_controller["revenu_total"];
                $plastique=   $quantite["plastique"];
                $papier=   $quantite["papier"];
                $composte=   $quantite["composte"];
                $canette=   $quantite["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
            public function RevenuTotaleFiltrerEtablissement($etablissement){
                $etab= Etablissement::where('nom_etablissement', $etablissement)->first() ;
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->FiltrageEtablissementGestionnaire($etab);
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $revenu=   $data_dashboard_etablissement_controller["revenu_total"];
                $plastique=   $revenu["plastique"];
                $papier=   $revenu["papier"];
                $composte=   $revenu["composte"];
                $canette=   $revenu["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
        /*      Revenu Responsable      */
            public function revenuEtablissementGestionnaire(){
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisGestionnaire();
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $quantite=   $data_dashboard_etablissement_controller["revenu_responsable"];
                $plastique=   $quantite["plastique"];
                $papier=   $quantite["papier"];
                $composte=   $quantite["composte"];
                $canette=   $quantite["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
            public function GestFiltrageRevenuEtablissement($etablissement){
                $etab= Etablissement::where('nom_etablissement', $etablissement)->first() ;
                $dashboard_etablissement_controller = new ViderPoubellesController;
                $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->FiltrageEtablissementGestionnaire($etab);
                $annee=   $data_dashboard_etablissement_controller["annee"];
                $revenu=   $data_dashboard_etablissement_controller["revenu_responsable"];
                $plastique=   $revenu["plastique"];
                $papier=   $revenu["papier"];
                $composte=   $revenu["composte"];
                $canette=   $revenu["canette"];
                return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
            }
        /*            quantite collecte        */
        public function quantiteCollecteMoisGestionnaire(){
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->SituationFianciereMoisGestionnaire();
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $quantite=   $data_dashboard_etablissement_controller["quantite"];
            $plastique=   $quantite["plastique"];
            $papier=   $quantite["papier"];
            $composte=   $quantite["composte"];
            $canette=   $quantite["canette"];
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
        public function quantiteCollecteEtablissementGestionnaire($etablissement){
            $etab= Etablissement::where('nom_etablissement', $etablissement)->first() ;
            $dashboard_etablissement_controller = new ViderPoubellesController;
            $data_dashboard_etablissement_controller = $dashboard_etablissement_controller->FiltrageEtablissementGestionnaire($etab);
            $annee=   $data_dashboard_etablissement_controller["annee"];
            $quantite=   $data_dashboard_etablissement_controller["quantite"];
            $plastique=   $quantite["plastique"];
            $papier=   $quantite["papier"];
            $composte=   $quantite["composte"];
            $canette=   $quantite["canette"];
            return ['annee'=>$annee,'plastique'=>$plastique,'papier'=>$papier,'composte'=>$composte,'canette'=>$canette];
        }
        public function EtablissementListe(){
            return Etablissement::pluck("nom_etablissement");
        }

}
