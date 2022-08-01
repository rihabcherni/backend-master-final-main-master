<?php
namespace App\Http\Controllers\API\TransportDechet;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Zone_depot as Zone_depotResource;
use App\Models\Zone_depot;
use App\Http\Requests\TransportDechet\Zone_depotRequest;
class Zone_depotController extends BaseController{
    public function index(){
        $zone_depot = Zone_depot::all();
        return $this->handleResponse(Zone_depotResource::collection($zone_depot), 'Affichage des zones de depots!');
    }
    public function store(Zone_depotRequest $request){
        $input = $request->all();
        $zone_depot = Zone_depot::create($input);
        return $this->handleResponse(new Zone_depotResource($zone_depot), 'Zone depot crée!');
    }
    public function show($id) {
        $zone_depot = Zone_depot::find($id);
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }else{
            return $this->handleResponse(new Zone_depotResource($zone_depot), 'Zone depot existe.');
        }
    }
    public function update(Zone_depotRequest $request, Zone_depot $zone_depot){
        $input = $request->all();
        $zone_depot->update($input);
        return $this->handleResponse(new Zone_depotResource($zone_depot), 'Zone depot modifié!');
    }
    public function destroy($id){
        $zone_depot =Zone_depot::find($id);
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }
        else{
            $zone_depot->delete();
            return $this->handleResponse(new Zone_depotResource($zone_depot), 'Zone depot supprimé!');
        }
    }

}
