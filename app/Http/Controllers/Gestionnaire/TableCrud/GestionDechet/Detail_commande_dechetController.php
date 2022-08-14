<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Detail_commande_dechet as Detail_commande_dechetResource;
use App\Models\Detail_commande_dechet;
use App\Http\Requests\GestionDechet\Detail_commande_dechetRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Detail_commande_dechetController extends BaseController{
    public function index(){
        $detail_commande = Detail_commande_dechet::all();
        return $this->handleResponse(Detail_commande_dechetResource::collection($detail_commande), 'tous les details des commandes dechet!');
    }
    public function store(Detail_commande_dechetRequest $request){
        $input = $request->all();
        $detail_commande = Detail_commande_dechet::create($input);
        return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet crée!');
    }
    public function show($id){
        $detail_commande = Detail_commande_dechet::find($id);
        if (count($detail_commande)==0) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet existante.');
        }
    }
    public function update(Detail_commande_dechetRequest $request, Detail_commande_dechet $detail_commande){
        $input = $request->all();
        $detail_commande->update($input);
        return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet modifié!');
    }
    public function destroy($id) {
        $detail_commande =Detail_commande_dechet::find($id);
        if (is_null($detail_commande)) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }
        else{
            $detail_commande->delete();
            return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet supprimé!');
        }
    }
    public function afficherDetailsDechet(Request $request){
        $detail_commande = Detail_commande_dechet::where('commande_dechet_id',$request->id)->get();
        if ( count($detail_commande)==0 ) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }else{
        return $this->handleResponse(Detail_commande_dechetResource::collection($detail_commande), 'tous les details des commandes dechet!');
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
