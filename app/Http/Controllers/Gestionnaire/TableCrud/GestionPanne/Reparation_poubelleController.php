<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;

use App\Exports\GestionPanne\Reparation_poubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparation_poubelle as Reparation_poubelleResource;
use App\Models\Reparation_poubelle;
use App\Http\Requests\GestionPanne\Reparation_poubelleRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Reparation_poubelleController extends BaseController{
    public function index() {
        $reparation_poubelle = Reparation_poubelle::all();
        return $this->handleResponse(Reparation_poubelleResource::collection($reparation_poubelle), 'Reparation poubelle have been retrieved!');
    }
    public function store(Reparation_poubelleRequest $request){
        $input = $request->all();
        $reparation_poubelle = Reparation_poubelle::create($input);
        return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle crée!');
    }
    public function show($id){
        $reparation_poubelle = Reparation_poubelle::find($id);
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle n\'existe pas');
        }else{
            return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle existe.');
        }
    }
    public function update(Reparation_poubelleRequest $request, Reparation_poubelle $reparation_poubelle){
        $input = $request->all();
        $reparation_poubelle->update($input);
        return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle modifié!');
    }
    public function destroy($id){
        $reparation_poubelle =Reparation_poubelle::find($id);
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle n\'existe pas!');
        }
        else{
            $reparation_poubelle->delete();
            return $this->handleResponse(new Reparation_poubelleResource($reparation_poubelle), 'reparation poubelle supprimé!');
        }
    }
    public function exportInfoReparationPoubelleExcel(){
        return Excel::download(new Reparation_poubelleExport  , 'reparation-poubelle-liste.xlsx');
    }

    public function exportInfoReparationPoubelleCSV(){
        return Excel::download(new Reparation_poubelleExport, 'reparation-poubelle-liste.csv');
    }

    public function pdfReparationPoubelle($id){
        $reparation_poubelle = Reparation_poubelle::find($id);
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle n\'existe pas!');
        }else{
            $data= collect(Reparation_poubelle::getReparationPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'reparateur_poubelle'=> $data[0]['reparateur_poubelle'],
                "reparateur_cin" => $data[0]['reparateur_cin'],
                "reparateur_nom_prenom" => $data[0]['reparateur_nom_prenom'],
                "nom_poubelle" => $data[0]['nom_poubelle'],
                "type" => $data[0]['type'],
                "etablissement" => $data[0]['etablissement'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "etage" => $data[0]['etage'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "poubelle_id" => $data[0]['poubelle_id'],
                "reparateur_poubelle_id" => $data[0]['reparateur_poubelle_id'],

                "image_panne_poubelle" => $data[0]['image_panne_poubelle'],
                "description_panne" => $data[0]['description_panne'],
                "cout" => $data[0]['cout'],
                "date_debut_reparation" => $data[0]['date_debut_reparation'],
                "date_fin_reparation" => $data[0]['date_fin_reparation'],

                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPanne/reparationPoubelle', $liste);
            return $pdf->download('reparation-poubelle.pdf');
        }
    }
    public function pdfAllReparationPoubelle(){
        $reparation_poubelle = Reparation_poubelle::all();
        if (is_null($reparation_poubelle)) {
            return $this->handleError('reparation poubelle  n\'existe pas!');
        }else{
            $p= Reparation_poubelleResource::collection( $reparation_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPanne/reparationPoubelle', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('reparation-poubelle.pdf');
        }
    }
}
