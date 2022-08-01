<?php
namespace App\Http\Controllers\API\GestionPanne;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparateur_poubelle as Reparateur_poubelleResource;
use App\Models\Reparateur_poubelle;
use App\Http\Requests\GestionPanne\Reparateur_poubelleRequest;
class Reparateur_poubelleController extends BaseController{
    public function index(){
        $reparateur_poubelle = Reparateur_poubelle::all();
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelle), 'affichage des reparateurs poubelles');
    }
    public function store(Reparateur_poubelleRequest $request) {
        $input = $request->all();
        $reparateur_poubelle = Reparateur_poubelle::create($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle crée!');
    }
    public function show($id){
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle not found!');
        }else{
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle existe.');
        }
    }
    public function update(Reparateur_poubelleRequest $request, Reparateur_poubelle $reparateur_poubelle){
        $input = $request->all();
        $reparateur_poubelle->update($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle modifié');
    }
    public function destroy($id){
        $reparateur_poubelle =Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle dechet n\'existe pas!');
        }
        else{
            $reparateur_poubelle->delete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle supprimé!');
        }
    }
}
