<?php
namespace App\Http\Controllers\API\TransportDechet;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Camion as CamionResource;
use App\Models\Camion;
use App\Http\Requests\TransportDechet\CamionRequest;
class CamionController extends BaseController{
    public function index() {
        $camion = Camion::all();
        return $this->handleResponse(CamionResource::collection($camion), 'affichagde des camions!');
    }
    public function store(CamionRequest $request){
        $input = $request->all();
        $camion = Camion::create($input);
        return $this->handleResponse(new CamionResource($camion), ' Camion crée!');
    }
    public function show($id){
        $camion = Camion::find($id);
        if (is_null($camion)) {
            return $this->handleError('poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new CamionResource($camion), ' Camion existante.');
        }
    }
    public function update(CamionRequest $request, Camion $camion){
        $input = $request->all();
        $camion->update($input);
        return $this->handleResponse(new CamionResource($camion), ' Camion modifié!');
    }
    public function destroy($id){
        $camion =Camion::find($id);
        if (is_null($camion)) {
            return $this->handleError('camion n\'existe pas!');
        }
        else{
            $camion->delete();
            return $this->handleResponse(new CamionResource($camion), ' Camion supprimé!');
        }
    }
}
