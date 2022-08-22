<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;

use App\Exports\GestionDechet\Commande_dechetExport;
use App\Exports\GestionDechet\Detail_commande_dechetExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Detail_commande_dechet as Detail_commande_dechetResource;
use App\Models\Detail_commande_dechet;
use App\Http\Requests\GestionDechet\Detail_commande_dechetRequest;
use App\Http\Resources\GestionDechet\Commande_dechet as GestionDechetCommande_dechet;
use App\Models\Commande_dechet;
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

    public function exportInfoDetailCommandeDechetExcel(){
        return Excel::download(new Commande_dechetExport  , 'Detail-commande-dechet-liste.xlsx');
    }

    public function exportInfoDetailCommandeDechetCSV(){
        return Excel::download(new Commande_dechetExport, 'Detail-commande-dechet-liste.csv');
    }
    public function pdfCommandeDechet($id){
        $Commande_dechet = Commande_dechet::find($id);
        if (is_null($Commande_dechet)) {
            return $this->handleError('Commande dechet n\'existe pas!');
        }else{
            $data= collect(Commande_dechet::getCommandeDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'type' => $data[0]['type'],
                'quantite' => $data[0]['quantite'],
                "matricule_fiscale" => $data[0]['matricule_fiscale'],
                "entreprise" => $data[0]['entreprise'],
                "client_dechet_id" => $data[0]['client_dechet_id'],
                "client_dechet" => $data[0]['client_dechet'],
                "montant_total" => $data[0]['montant_total'],
                "date_commande" => $data[0]['date_commande'],
                "date_livraison" => $data[0]['date_livraison'],
                "type_paiment" => $data[0]['type_paiment'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionDechet/commandeDechet', $liste);
            return $pdf->download('commande-dechet.pdf');
        }
    }
    public function pdfAllCommandeDechet(){
        $Commande_dechet = Commande_dechet::all();
        if (is_null($Commande_dechet)) {
            return $this->handleError('Commande dechet n\'existe pas!');
        }else{
            $p= GestionDechetCommande_dechet::collection( $Commande_dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionDechet/commandeDechet', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('commande-dechet.pdf');
        }
    }
}
