<?php
namespace App\Http\Controllers\API\GestionPoubelleEtablissements;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_poubelle as Bloc_poubelleResource;
use App\Models\Bloc_poubelle;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_poubelleRequest;
class Bloc_poubelleController extends BaseController{
    public function index(){
        $bloc_poubelle = Bloc_poubelle::all();
        return $this->handleResponse(Bloc_poubelleResource::collection($bloc_poubelle), 'Affichage des blocs poubelle!');
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
