<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
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
            return $this->handleError('reparation camion dechet n\'existe pas!');
        }
        else{
            $reparation_camion->delete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion supprimé!');
        }
    }
    public function exportInfoClientDechetExcel(){
        return Excel::download(new ClientDechetExport  , 'client-dechet-liste.xlsx');
    }

    public function exportInfoClientDechetCSV(){
        return Excel::download(new ClientDechetExport, 'client-dechet-liste.csv');
    }

    public function pdfClientDechet($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            $data= collect(Client_dechet::getClientDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'poubelle_id_resp' =>   $data[0]['poubelle_id_resp'],

                "etablissement" => $data[0]['etablissement'],
                "etablissement_id" =>  $data[0]['etablissement_id'],
                "nom" => $data[0]['nom'],
                "nom_poubelle_responsable" => $data[0]['nom_poubelle_responsable'],
                "type" => $data[0]['type'],
                "Etat" => $data[0]['Etat'],
                "quantite" => $data[0]['quantite'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "bloc_poubelle_id_resp" => $data[0]['bloc_poubelle_id_resp'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],

                "etage" => $data[0]['etage'],
                "etage_id" => $data[0]['etage_id'],
                "qrcode" => $data[0]['qrcode'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionCompte/clientDechet', $liste);
            return $pdf->download('client-dechet.pdf');
        }
    }
    public function pdfAllClientDechet(){
        $client = Client_dechet::all();
        if (is_null($client)) {
            return $this->handleError('client dechet n\'existe pas!');
        }else{
            $p= Client_dechetResource::collection( $client);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionCompte/clientDechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('client-dechet.pdf');
        }
    }
}
