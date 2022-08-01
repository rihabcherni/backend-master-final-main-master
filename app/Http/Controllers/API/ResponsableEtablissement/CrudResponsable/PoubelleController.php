<?php
namespace App\Http\Controllers\API\ResponsableEtablissement\CrudResponsable;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;
use App\Models\Poubelle;
use App\Http\Requests\GestionPoubelleEtablissements\PoubelleRequest;
use App\Models\Bloc_etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etablissement;
use App\Models\Etage_etablissement;

class PoubelleController extends BaseController{
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

        $poubelleTable=[];
        foreach($bloc_poubelle as $poub){
            $p = Poubelle::where('bloc_poubelle_id',$poub->id)->get();
            array_push($poubelleTable,$p);
        }

        $po=[];
        foreach($poubelleTable as $ppp){
            foreach($ppp as $pelement){
                $pbloc= Bloc_poubelle::where('id',$pelement->bloc_poubelle_id)->first();
                $petage= Etage_etablissement::where('id',$pbloc->etage_etablissement_id)->first();
                $betablissement= Bloc_etablissement::where('id',$petage->bloc_etablissement_id)->first();
                $pelement["nom_etage"]= $petage['nom_etage_etablissement'];
                $pelement["nom_bloc"]= $betablissement['nom_bloc_etablissement'];
                array_push($po,$pelement);
            }
        }

        return $this->handleResponse($po, 'Tous les poubelles!');
    }
    public function store(PoubelleRequest $request){
        $input = $request->all();
        $poubelle = Poubelle::create($input);
        return $this->handleResponse(new PoubelleResource($poubelle),'poubelle crée!');
    }
    public function show($id){
        $poubelle = Poubelle::find($id);
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new PoubelleResource($poubelle), 'poubelle existe');
        }
    }
    public function update(PoubelleRequest $request, Poubelle $poubelle){
        $input = $request->all();
        $poubelle->update($input);
        return $this->handleResponse(new PoubelleResource($poubelle), ' poubelle modifié!');
    }
    public function destroy($id){
        $poubelle =Poubelle::find($id);
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }
        else{
            $poubelle->delete();
            return $this->handleResponse(new PoubelleResource($poubelle), ' poubelle supprimé!');
        }
    }
}
