<?php
namespace App\Http\Controllers\API\GestionPanne;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparation_camion as Reparation_camionResource;
use App\Models\Reparation_camion;
use App\Http\Requests\GestionPanne\Reparation_camionRequest;

class Reparation_camionController extends BaseController{
    public function index(){
        $reparation_camion = Reparation_camion::all();
        return $this->handleResponse(Reparation_camionResource::collection($reparation_camion), 'affichage des reparations camions!');
    }
    public function store(Reparation_camionRequest $request){
        $input = $request->all();
        $reparation_camion = Reparation_camion::create($input);
        return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion crée!');
    }
    public function show($id){
        $reparation_camion = Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError(' Reparation camion n\'existe pas!');
        }else{
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'Reparation camion existe.');
        }
    }
    public function update(Reparation_camionRequest $request, Reparation_camion $reparation_camion){
        $input = $request->all();
        $reparation_camion->update($input);
        return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion modifié!');
    }
    public function destroy($id){
        $reparation_camion =Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion dechet n\'existe pas!');
        }
        else{
            $reparation_camion->delete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion supprimé!');
        }
    }
}
