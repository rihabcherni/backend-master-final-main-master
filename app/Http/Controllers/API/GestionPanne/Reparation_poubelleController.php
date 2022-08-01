<?php
namespace App\Http\Controllers\API\GestionPanne;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparation_poubelle as Reparation_poubelleResource;
use App\Models\Reparation_poubelle;
use App\Http\Requests\GestionPanne\Reparation_poubelleRequest;
class Reparation_poubelleController extends BaseController{
    public function index() {
        $reparation_poubelle = Reparation_poubelle::all();
        return $this->handleResponse(Reparation_poubelleResource::collection($reparation_poubelle), 'Reparation poubelle have been retrieved!');
    }
    public function store(Reparation_poubelleRequest $request){
        $input = $request->all();
        $reparation_poubelle = Reparation_poubelle::create($input);
        return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle crée!');
    }
    public function show($id){
        $reparation_poubelle = Reparation_poubelle::find($id);
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle n\'existe pas');
        }else{
            return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle existe.');
        }
    }
    public function update(Reparation_poubelleRequest $request, Reparation_poubelle $reparation_poubelle){
        $input = $request->all();
        $reparation_poubelle->update($input);
        return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle modifié!');
    }
    public function destroy($id){
        $reparation_poubelle =Reparation_poubelle::find($id);
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle dechet n\'existe pas!');
        }
        else{
            $reparation_poubelle->delete();
            return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle supprimé!');
        }
    }
}
