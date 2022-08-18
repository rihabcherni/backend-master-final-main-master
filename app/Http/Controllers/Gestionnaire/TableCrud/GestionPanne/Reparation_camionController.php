<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;

use App\Exports\GestionPanne\Reparation_camionExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparation_camion as Reparation_camionResource;
use App\Models\Reparation_camion;
use App\Http\Requests\GestionPanne\Reparation_camionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
            return $this->handleError('reparation camion n\'existe pas!');
        }
        else{
            $reparation_camion->delete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion supprimé!');
        }
    }
    public function exportInfoReparationCamionExcel(){
        return Excel::download(new Reparation_camionExport  , 'reparation-camion-liste.xlsx');
    }
    public function exportInfoReparationCamionCSV(){
        return Excel::download(new Reparation_camionExport, 'reparation-camion-liste.csv');
    }
    public function pdfReparationCamion($id){
        $reparation_camion = Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }else{
            $data= collect(Reparation_camion::getReparationCamionById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "camion_id" => $data[0]['camion_id'],
                "matricule" => $data[0]['matricule'],
                "mecanicien_id" => $data[0]['mecanicien_id'],
                "mecanicien_CIN" => $data[0]['mecanicien_CIN'],
                "mecanicien_nom_prenom" => $data[0]['mecanicien_nom_prenom'],
                "image_panne_camion" => $data[0]['image_panne_camion'],
                "description_panne" => $data[0]['description_panne'],
                "camion" => $data[0]['camion'],
                "mecanicien" => $data[0]['mecanicien'],
                "cout" => $data[0]['cout'],
                "date_debut_reparation" => $data[0]['date_debut_reparation'],
                "date_fin_reparation" => $data[0]['date_fin_reparation'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionPanne/reparationCamion', $liste);
            return $pdf->download('reparation-camion.pdf');
        }
    }
    public function pdfAllReparationCamion(){
        $reparation_camion = Reparation_camion::all();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }else{
            $p= Reparation_camionResource::collection( $reparation_camion);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPanne/reparationCamion', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('reparation-camion.pdf');
        }
    }
}
