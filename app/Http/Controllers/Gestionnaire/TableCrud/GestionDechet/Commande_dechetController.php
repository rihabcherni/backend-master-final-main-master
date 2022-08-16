<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;

use App\Exports\GestionDechet\Commande_dechetExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Commande_dechet as Commande_dechetResource;
use App\Models\Commande_dechet;
use App\Http\Requests\GestionDechet\Commande_dechetRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Commande_dechetController extends BaseController{
    public function index(){
        $commande = Commande_dechet::all();
        return $this->handleResponse(Commande_dechetResource::collection($commande), 'tous les commandes de dechets!');
    }
    public static function store(Commande_dechetRequest $request){
        $input = $request->all();
        $commande = Commande_dechet::create($input);
        return $this->handleResponse(new Commande_dechetResource($commande), 'commande crée!');
    }
    public function show($id){
        $commande = Commande_dechet::find($id);
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new Commande_dechetResource($commande), 'commande existante.');
        }
    }
    public function update(Commande_dechetRequest $request, Commande_dechet $commande){
        $input = $request->all();
        $commande->update($input);
        return $this->handleResponse(new Commande_dechetResource($commande), 'commande modifié!');
    }
    public function destroy($id) {
        $commande =Commande_dechet::find($id);
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }
        else{
            $commande->delete();
            return $this->handleResponse(new Commande_dechetResource($commande), 'commande dechet supprimé!');
        }
    }
    public function afficherDechetsClient(){
        $commande = Commande_dechet::where('client_dechet_id', '=',auth()->guard('client_dechet')->user()->id)->get();
        if (is_null($commande)) {
            return $this->handleError('commande dechet n\'existe pas!');
        }
        else{
            return $this->handleResponse(Commande_dechetResource::collection($commande), 'tous les commandes de dechets!');
        }
    }
    public function exportInfoCommandeDechetExcel(){
        return Excel::download(new Commande_dechetExport  , 'commande-dechet-liste.xlsx');
    }

    public function exportInfoCommandeDechetCSV(){
        return Excel::download(new Commande_dechetExport, 'commande-dechet-liste.csv');
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
            $p= Commande_dechetResource::collection( $Commande_dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionDechet/commandeDechet', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('commande-dechet.pdf');
        }
    }
}
