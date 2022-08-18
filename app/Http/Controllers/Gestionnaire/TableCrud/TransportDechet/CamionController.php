<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet;

use App\Exports\TransportDechet\CamionExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Camion as CamionResource;
use App\Models\Camion;
use App\Http\Requests\TransportDechet\CamionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
    public function exportInfoCamionExcel(){
        return Excel::download(new CamionExport  , 'camion-liste.xlsx');
    }
    public function exportInfoCamionCSV(){
        return Excel::download(new CamionExport, 'camion-liste.csv');
    }
    public function pdfCamion($id){
        $camion = Camion::find($id);
        if (is_null($camion)) {
            return $this->handleError('Camion n\'existe pas!');
        }else{
            $data= collect(Camion::getCamionById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'zone_travail'=> $data[0]['zone_travail'],
                'zone_depot'=> $data[0]['zone_depot'],
                'ouvrier'=> $data[0]['ouvrier'],
                "zone_travail_id" => $data[0]['zone_travail_id'],
                "zone_depot_id" => $data[0]['zone_depot_id'],
                "matricule" => $data[0]['matricule'],
                "heure_sortie" => $data[0]['heure_sortie'],
                "heure_entree" => $data[0]['heure_entree'],
                "longitude" => $data[0]['longitude'],
                "latitude" => $data[0]['latitude'],
                "volume_maximale_camion" => $data[0]['volume_maximale_camion'],
                "volume_actuelle_plastique" => $data[0]['volume_actuelle_plastique'],
                "volume_actuelle_papier" => $data[0]['volume_actuelle_papier'],
                "volume_actuelle_composte" => $data[0]['volume_actuelle_composte'],
                "volume_actuelle_canette" => $data[0]['volume_actuelle_canette'],
                "volume_carburant_consomme" => $data[0]['volume_carburant_consomme'],
                "Kilometrage" => $data[0]['Kilometrage'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/TransportDechet/camion', $liste);
            return $pdf->download('camion.pdf');
        }
    }
    public function pdfAllCamion(){
        $camion = Camion::all();
        if (is_null($camion)) {
            return $this->handleError('camion n\'existe pas!');
        }else{
            $p= CamionResource::collection( $camion);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/TransportDechet/camion', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('camion.pdf');
        }
    }
}
