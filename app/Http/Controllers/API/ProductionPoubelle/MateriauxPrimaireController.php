<?php
namespace App\Http\Controllers\API\ProductionPoubelle;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\MateriauxPrimaire as MateriauxPrimaireResource;
use App\Models\Materiau_primaire;
use App\Http\Requests\ProductionPoubelle\MateriauxPrimaireRequest;

class MateriauxPrimaireController extends BaseController{
    public function index(){
        $materiauxPrimaire = Materiau_primaire::all();
        return $this->handleResponse(MateriauxPrimaireResource::collection($materiauxPrimaire), 'Affichage des materiauxPrimaire');
    }
    public function store(MateriauxPrimaireRequest $request){
        $input = $request->all();
        $materiauxPrimaire = Materiau_primaire::create($input);
        return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau primaire crée!');
    }
    public function show($id){
        $materiauxPrimaire = Materiau_primaire::find($id);
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiau Primaire not found!');
        }else{
            return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau Primaire existe.');
        }
    }
    public function update(MateriauxPrimaireRequest $request, Materiau_primaire $materiauxPrimaire){
        $input = $request->all();
        $materiauxPrimaire->update($input);
        return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), ' materiau Primaire modifié!');
    }
    public function destroy($id){
        $materiauxPrimaire =Materiau_primaire::find($id);
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiaux Primaire n\'existe pas!');
        }
        else{
            $materiauxPrimaire->delete();
            return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau Primaire supprimé!');
        }
    }
}
