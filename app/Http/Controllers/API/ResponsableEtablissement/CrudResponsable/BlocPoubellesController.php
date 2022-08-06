<?php
namespace App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_poubelle as Bloc_poubelleResource;
use App\Models\Bloc_poubelle;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_poubelleRequest;
use App\Models\Etablissement;
use App\Models\Bloc_etablissement;
use App\Models\Etage_etablissement;

class BlocPoubellesController extends BaseController{
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
        $bloctable=[];
        foreach($etages as $et){
            $bp = Bloc_poubelle::where('etage_etablissement_id',$et->id)->get();
            array_push($bloctable,$bp);
        }

        $bloc_poubelle=[];
        foreach($bloctable as $bloc){
            foreach($bloc as $belement){
                $bb= Etage_etablissement::where('id',$belement->etage_etablissement_id)->first();
                $betablissement= Bloc_etablissement::where('id',$bb->bloc_etablissement_id)->first();
                $belement["nom_etage"]= $bb['nom_etage_etablissement'];
                $belement["nom_bloc"]= $betablissement['nom_bloc_etablissement'];
                array_push($bloc_poubelle,$belement);
            }
        }
        return $this->handleResponse($bloc_poubelle, 'Affichage des blocs poubelle!');
    }
    public function store(Bloc_poubelleRequest $request){
        $input = $request->all();
        $bloc_poubelle = Bloc_poubelle::create($input);
        return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'Block poubelle crée!');
    }
    public function show($id){
        $bloc_poubelle = Bloc_poubelle::find($id);
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle existante.');
        }
    }
    public function update(Bloc_poubelleRequest $request, Bloc_poubelle $bloc_poubelle){
        $input = $request->all();
        $bloc_poubelle->update($input);
        return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle modifié!');
    }
    public function destroy($id){
        $bloc_poubelle =Bloc_poubelle::find($id);
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }
        else{
            $bloc_poubelle->delete();
            return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle supprimé!');
        }
    }
}
