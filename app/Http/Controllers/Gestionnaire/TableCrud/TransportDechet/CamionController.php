<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet;
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
