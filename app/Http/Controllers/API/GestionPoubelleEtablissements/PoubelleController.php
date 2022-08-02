<?php
namespace App\Http\Controllers\API\GestionPoubelleEtablissements;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;
use App\Models\Poubelle;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GestionPoubelleEtablissements\PoubelleRequest;
class PoubelleController extends BaseController{
    public function index(){
        $poubelle = Poubelle::all();
        return $this->handleResponse(PoubelleResource::collection($poubelle), 'Tous les poubelles!');
    }
    public function store(PoubelleRequest $request){
        $input = $request->all();
        $last_id=Poubelle::count()+1;
        $poubelleNom=$request->nom_etablissement.'-'.$request->nom_bloc_etablissement.'-E'.$request->nom_etage_etablissement.'-BP'.$request->bloc_poubelle_id.'-N'.$last_id;
        $qrcode= Hash::make($poubelleNom);
        $input['QRcode']=  $qrcode;
        $input['nom']=  $poubelleNom;
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
