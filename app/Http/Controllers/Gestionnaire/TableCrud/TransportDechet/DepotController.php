<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Depot as DepotResource;
use App\Models\Depot;
use App\Http\Requests\TransportDechet\DepotRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
