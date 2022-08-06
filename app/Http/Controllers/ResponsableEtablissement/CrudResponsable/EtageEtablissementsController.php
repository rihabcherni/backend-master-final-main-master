<?php

namespace App\Http\Controllers\ResponsableEtablissement\CrudResponsable;

use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Etage_etablissements as Etage_etablissementsResource;
use App\Models\Etage_etablissement;
use App\Models\Bloc_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Etage_etablissementsRequest;
use App\Models\Etablissement;

class EtageEtablissementsController extends BaseController{
    public function index(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($etab_id);
        $bloc_etablissement = Bloc_etablissement::where('etablissement_id',$etablissement->id)->get();
        $t=[];
        foreach($bloc_etablissement as $bloc){
            $id_bloc=$bloc->id;
            $etage_etablissement = Etage_etablissement::where('bloc_etablissement_id',$id_bloc)->get();
            array_push($t,$etage_etablissement);
        }
        $etages=[];
        foreach($t as $etage){
            foreach($etage as $e){
                $b= Bloc_etablissement::where('id',$e->bloc_etablissement_id)->first();
                $e["nom_bloc"]= $b['nom_bloc_etablissement'];
                array_push($etages,$e);
            }
        }
        return $this->handleResponse($etages, 'Affichage des etages etablissement!');
    }
    public function store(Etage_etablissementsRequest $request){
        $input = $request->all();
        $etage_etablissement = Etage_etablissement::create($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'Block etablissement crée!');
    }
    public function show($id){
        $etage_etablissement = Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement existante.');
        }
    }
    public function update(Etage_etablissementsRequest $request, Etage_etablissement $etage_etablissement){
        $input = $request->all();
        $etage_etablissement->update($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement modifié!');
    }
    public function destroy($id){
        $etage_etablissement =Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }
        else{
            $etage_etablissement->delete();
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement supprimé!');
        }
    }

}


