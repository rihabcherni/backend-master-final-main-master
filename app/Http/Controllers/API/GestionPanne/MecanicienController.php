<?php
namespace App\Http\Controllers\API\GestionPanne;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Mecanicien as MecanicienResource;
use App\Models\Mecanicien;
use App\Http\Requests\GestionPanne\MecanicienRequest;
class MecanicienController extends BaseController{
    public function index(){
        $mecanicien = Mecanicien::all();
        return $this->handleResponse(MecanicienResource::collection($mecanicien), 'affichage de tous les mecaniciens');
    }
    public function store(MecanicienRequest $request){
        $input = $request->all();
        $mecanicien = Mecanicien::create($input);
        return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien crée!');
    }
    public function show($id){
        $mecanicien = Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('Mecanicien n\'existe pas!');
        }else{
            return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien existe.');
        }
    }
    public function update(MecanicienRequest $request, Mecanicien $mecanicien){
        $input = $request->all();
        $mecanicien->update($input);
        return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien modifié!');
    }
    public function destroy($id) {
        $mecanicien =Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('dechet n\'existe pas!');
        }
        else{
            $mecanicien->delete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien supprimé!');
        }
    }
}
