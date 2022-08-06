<?php

namespace App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable;

use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_etablissements as Bloc_etablissementsResource;
use App\Models\Bloc_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_etablissementsRequest;
use App\Models\Etablissement;

class Bloc_etablissementsController extends BaseController
{
    public function index(){
        $responable_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($responable_id);
        $bloc_etablissement = Bloc_etablissement::where('etablissement_id',$etablissement->id)->get();
        return $this->handleResponse(Bloc_etablissementsResource::collection($bloc_etablissement), 'Affichage des blocs etablissement!');
    }
    public function store(Bloc_etablissementsRequest $request){
        $responable_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $etablissement= Etablissement::find($responable_id);

        $request['etablissement_id']=$etablissement->id;
        $input = $request->all();

        if($input['etablissement_id']===$etablissement->id){
            $bloc_etablissement = Bloc_etablissement::create($input);
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'Block etablissement crée!');
        }else return $request;

    }
    public function show($id){
        $bloc_etablissement = Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement existante.');
        }
    }
    public function update(Bloc_etablissementsRequest $request, Bloc_etablissement $bloc_etablissement){
        $input = $request->all();
        $bloc_etablissement->update($input);
        return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement modifié!');
    }
    public function destroy($id){
        $bloc_etablissement =Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }
        else{
            $bloc_etablissement->delete();
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement supprimé!');
        }
    }

}

