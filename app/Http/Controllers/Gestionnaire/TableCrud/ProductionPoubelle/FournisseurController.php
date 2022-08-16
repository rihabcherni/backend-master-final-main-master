<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;

use App\Exports\ProductionPoubelle\FournisseurExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\Fournisseur as FournisseurResource;
use App\Models\Fournisseur;
use App\Http\Requests\ProductionPoubelle\FournisseurRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class FournisseurController extends BaseController{
    public function index(){
        $fournisseur = Fournisseur::all();
        return $this->handleResponse(FournisseurResource::collection($fournisseur), 'Affichage des fournisseurs');
    }
    public function store(FournisseurRequest $request){
        $input = $request->all();
        $fournisseur = Fournisseur::create($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur crée!');
    }
    public function show($id){
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur existe.');
        }
    }
    public function update(FournisseurRequest $request, Fournisseur $fournisseur){
        $input = $request->all();
        $fournisseur->update($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), ' fournisseur modifié!');
    }
    public function destroy($id){
        $fournisseur =Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }
        else{
            $fournisseur->delete();
            return $this->handleResponse(new FournisseurResource($fournisseur),'fournisseur supprimé!');
        }
    }
    public function exportInfoFournisseurExcel(){
        return Excel::download(new FournisseurExport  , 'fournisseur-liste.xlsx');
    }
    public function exportInfoFournisseurCSV(){
        return Excel::download(new FournisseurExport, 'fournisseur-liste.csv');
    }
    public function pdfFournisseur($id){
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            $data= collect(Fournisseur::getFournisseurById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom"=> $data[0]['nom'],
                "prenom"=> $data[0]['prenom'],
                "CIN"=> $data[0]['CIN'],
                "photo"=> $data[0]['photo'],
                "numero_telephone"=> $data[0]['numero_telephone'],
                "email"=> $data[0]['email'],
                "adresse"=> $data[0]['adresse'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/ProductionPoubelle/fournisseur', $liste);
            return $pdf->download('fournisseur.pdf');
        }
    }
    public function pdfAllFournisseur(){
        $fournisseur = Fournisseur::all();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            $p= FournisseurResource::collection( $fournisseur);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/ProductionPoubelle/fournisseur', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('fournisseur.pdf');
        }
    }
}
