<?php
namespace App\Http\Controllers\API\GestionPoubelleEtablissements;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Etablissement as EtablissementResource;
use App\Models\Etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\EtablissementRequest;
class EtablissementController extends BaseController{
    public function index(){
        $etablissement = Etablissement::all();
        return $this->handleResponse(EtablissementResource::collection($etablissement), 'Affichage des etablissements!');
    }
    public function store(EtablissementRequest $request){
        $input = $request->all();
        $etablissement = Etablissement::create($input);
        return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement crée!');
    }
    public function show($id){
        $etablissement = Etablissement::find($id);
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement existante.');
        }
    }
    public function update(EtablissementRequest $request, Etablissement $etablissement){
        $input = $request->all();
        $etablissement->update($input);
        return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement modifié!');
    }
    public function destroy($id){
        $etablissement =Etablissement::find($id);
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }
        else{
            $etablissement->delete();
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement supprimé!');
        }
    }

}
