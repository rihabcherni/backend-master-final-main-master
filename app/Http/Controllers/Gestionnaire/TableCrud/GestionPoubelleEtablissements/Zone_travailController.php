<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Zone_travail as Zone_travailResource;
use App\Http\Requests\GestionPoubelleEtablissements\Zone_travailRequest;
use App\Models\Zone_travail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Zone_travailController extends BaseController{
    public function index(){
        $zone_travail = Zone_travail::all();
        return $this->handleResponse(Zone_travailResource::collection($zone_travail), 'affichage de tous les zone travail!');
    }
    public function store(Zone_travailRequest $request){
        $input = $request->all();
        $input['quantite_total_collecte_plastique']=0;
        $input['quantite_total_collecte_papier']=0;
        $input['quantite_total_collecte_composte']=0;
        $input['quantite_total_collecte_canette']=0;
        $zone_travail = Zone_travail::create($input);
        return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail crée!');
    }
    public function show($id) {
        $zone_travail = Zone_travail::find($id);
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail existe.');
        }
    }
    public function update(Zone_travailRequest $request, Zone_travail $zone_travail){
        $input = $request->all();
        $zone_travail->update($input);
        return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail modifié avec succés');
    }
    public function destroy($id){
        $zone_travail =Zone_travail::find($id);
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }
        else{
            $zone_travail->delete();
            return $this->handleResponse(new Zone_travailResource($zone_travail), ' zone travail supprimé!');
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
