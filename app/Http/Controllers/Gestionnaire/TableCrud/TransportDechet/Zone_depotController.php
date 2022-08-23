<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet;

use App\Exports\TransportDechet\Zone_depotExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Zone_depot as Zone_depotResource;
use App\Models\Zone_depot;
use App\Http\Requests\TransportDechet\Zone_depotRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function hdelete( $id) {
        $zone_depot = Zone_depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }else{
            $zone_depot->forceDelete();
            return $this->handleResponse(new Zone_depotResource($zone_depot), 'zone depot supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $zone_depots = Zone_depot::onlyTrashed()->get();
        foreach($zone_depots as $zone_depot){
            $zone_depot->forceDelete();
        }
        return $this->handleResponse(Zone_depotResource::collection($zone_depots), 'tous zones depots supprimés définitivement');
    }
    public function restore( $id) {
        $zone_depot = Zone_depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        } else{
            $zone_depot->restore();
            return $this->handleResponse(new Zone_depotResource($zone_depot), 'zone depot supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $zone_depots= Zone_depot::onlyTrashed()->get();
        foreach($zone_depots as $zone_depot){
            $zone_depot->restore();
        }
        return $this->handleResponse(Zone_depotResource::collection($zone_depots), 'tous zones depots restore');
    }
    public function listeSuppression(){
        $zone_depot = Zone_depot::onlyTrashed()->get();
        return $this->handleResponse(Zone_depotResource::collection($zone_depot), 'affichage des zones depots supprimés');
    }
    public function exportInfoExcel(){
        return Excel::download(new Zone_depotExport, 'zone-depot-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Zone_depotExport, 'zone-depot-liste.csv');
    }

    public function pdf($id){
        $zone_depot = Zone_depot::find($id);
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot  n\'existe pas!');
        }else{
            $data= collect(Zone_depot::getZoneDepotById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "zone_travail_id" => $data[0]['zone_travail_id'],
                "zone_travail" => $data[0]['zone_travail'],
                "adresse" => $data[0]['adresse'],
                "longitude" => $data[0]['longitude'],
                "latitude" => $data[0]['latitude'],
                "quantite_depot_maximale" => $data[0]['quantite_depot_maximale'],
                "quantite_depot_actuelle_plastique" => $data[0]['quantite_depot_actuelle_plastique'],
                "quantite_depot_actuelle_papier"=> $data[0]['quantite_depot_actuelle_papier'],
                "quantite_depot_actuelle_composte"=>$data[0]['quantite_depot_actuelle_composte'],
                "quantite_depot_actuelle_canette" => $data[0]['quantite_depot_actuelle_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/TransportDechet/zoneDepot', $liste);
            return $pdf->download('zone-depot.pdf');
        }
    }
    public function pdfAll(){
        $zone_depot = Zone_depot::all();
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }else{
            $p= Zone_depotResource::collection( $zone_depot);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/TransportDechet/zoneDepot', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('zone-depot.pdf');
        }
    }
    public function pdfAllTrashed(){
        $zone_depot = Zone_depot::onlyTrashed()->get();
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }else{
            $p= Zone_depotResource::collection( $zone_depot);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/TransportDechet/zoneDepot', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('zone-depot-supprimes.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $zone_depot = Zone_depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_depot)) {
            return $this->handleError('zone depot n\'existe pas!');
        }else{
            $data= collect(Zone_depot::getZoneDepotByIdTrashed($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "zone_travail_id" => $data[0]['zone_travail_id'],
                "zone_travail" => $data[0]['zone_travail'],
                "adresse" => $data[0]['adresse'],
                "longitude" => $data[0]['longitude'],
                "latitude" => $data[0]['latitude'],
                "quantite_depot_maximale" => $data[0]['quantite_depot_maximale'],
                "quantite_depot_actuelle_plastique" => $data[0]['quantite_depot_actuelle_plastique'],
                "quantite_depot_actuelle_papier"=> $data[0]['quantite_depot_actuelle_papier'],
                "quantite_depot_actuelle_composte"=>$data[0]['quantite_depot_actuelle_composte'],
                "quantite_depot_actuelle_canette" => $data[0]['quantite_depot_actuelle_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
                'deleted_at' => $data[0]['deleted_at'],
            ];
            $pdf = Pdf::loadView('pdf/Delete/unique/TransportDechet/zoneDepot', $liste);
            return $pdf->download('zone-depot-supprime.pdf');
            }
        }
}

