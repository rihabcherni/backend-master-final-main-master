<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;

use App\Exports\GestionPanne\Reparateur_poubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparateur_poubelle as Reparateur_poubelleResource;
use App\Models\Reparateur_poubelle;
use App\Http\Requests\GestionPanne\Reparateur_poubelleRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Reparateur_poubelleController extends BaseController{
    public function index(){
        $reparateur_poubelle = Reparateur_poubelle::all();
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelle), 'affichage des reparateurs poubelles');
    }
    public function store(Reparateur_poubelleRequest $request) {
        $input = $request->all();
        $reparateur_poubelle = Reparateur_poubelle::create($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle crée!');
    }
    public function show($id){
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle not found!');
        }else{
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle existe.');
        }
    }
    public function update(Reparateur_poubelleRequest $request, Reparateur_poubelle $reparateur_poubelle){
        $input = $request->all();
        $reparateur_poubelle->update($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle modifié');
    }
    public function destroy($id){
        $reparateur_poubelle =Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle n\'existe pas!');
        }
        else{
            $reparateur_poubelle->delete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle supprimé!');
        }
    }
    public function exportInfoReparateurPoubelleExcel(){
        return Excel::download(new Reparateur_poubelleExport  , 'reparateur-poubelle-liste.xlsx');
    }

    public function exportInfoReparateurPoubelleCSV(){
        return Excel::download(new Reparateur_poubelleExport, 'reparateur-poubelle-liste.csv');
    }

    public function pdfReparateurPoubelle($id){
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle n\'existe pas!');
        }else{
            $data= collect(Reparateur_poubelle::getReparateurPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom" => $data[0]['nom'],
                "prenom" => $data[0]['prenom'],
                "CIN" => $data[0]['CIN'],
                "photo" => $data[0]['photo'],
                "numero_telephone" => $data[0]['numero_telephone'],
                "email" => $data[0]['email'],
                "adresse" => $data[0]['adresse'],
                "Liste_poubelles_repares"=> $data[0]['Liste_poubelles_repares'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPanne/reparateurPoubelle', $liste);
            return $pdf->download('reparateur-poubelle.pdf');
        }
    }
    public function pdfAllReparateurPoubelle(){
        $reparateur_poubelle = Reparateur_poubelle::all();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle n\'existe pas!');
        }else{
            $p= Reparateur_poubelleResource::collection( $reparateur_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPanne/reparateurPoubelle', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('reparateur-poubelle.pdf');
        }
    }
}
