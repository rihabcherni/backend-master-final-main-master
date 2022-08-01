<?php
namespace App\Http\Controllers\API\TransportDechet;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Depot as DepotResource;
use App\Models\Depot;
use App\Http\Requests\TransportDechet\DepotRequest;
class DepotController extends BaseController{
    public function index(){
        $depot = Depot::all();
        return $this->handleResponse(DepotResource::collection($depot), 'affichage Depots!');
    }
    public function store(DepotRequest $request){
        $input = $request->all();
        $depot = Depot::create($input);
        return $this->handleResponse(new DepotResource($depot), 'depot crée!');
    }
    public function show($id){
        $depot = Depot::find($id);
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            return $this->handleResponse(new DepotResource($depot), 'depot existe.');
        }
    }
    public function update(DepotRequest $request, Depot $depot){
        $input = $request->all();
        $depot->update($input);
        return $this->handleResponse(new DepotResource($depot), 'depot modifié!');
    }
    public function destroy($id){
        $depot =Depot::find($id);
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }
        else{
            $depot->delete();
            return $this->handleResponse(new DepotResource($depot), 'depot supprimé!');
        }
    }

}
