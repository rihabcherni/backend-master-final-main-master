<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;

use App\Exports\GestionPoubelleEtablissements\Bloc_poubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_poubelle as Bloc_poubelleResource;
use App\Models\Bloc_poubelle;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_poubelleRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Bloc_poubelleController extends BaseController{
    public function index(){
        $bloc_poubelle = Bloc_poubelle::all();
        return $this->handleResponse(Bloc_poubelleResource::collection($bloc_poubelle), 'Affichage des blocs poubelle!');
    }
    public function store(Bloc_poubelleRequest $request){
        $input = $request->all();
        $bloc_poubelle = Bloc_poubelle::create($input);
        return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'Block poubelle crée!');
    }
    public function show($id){
        $bloc_poubelle = Bloc_poubelle::find($id);
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle existante.');
        }
    }
    public function update(Bloc_poubelleRequest $request, Bloc_poubelle $bloc_poubelle){
        $input = $request->all();
        $bloc_poubelle->update($input);
        return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle modifié!');
    }
    public function destroy($id){
        $bloc_poubelle =Bloc_poubelle::find($id);
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }
        else{
            $bloc_poubelle->delete();
            return $this->handleResponse(new Bloc_poubelleResource($bloc_poubelle), 'bloc poubelle supprimé!');
        }
    }
    public function exportInfoBlocPoubelleExcel(){
        return Excel::download(new Bloc_poubelleExport  , 'bloc-poubelle-liste.xlsx');
    }

    public function exportInfoBlocPoubelleCSV(){
        return Excel::download(new Bloc_poubelleExport, 'bloc-poubelle-liste.csv');
    }
    public function pdfBlocPoubelle($id){
        $bloc_poubelle = Bloc_poubelle::find($id);
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }else{
            $data= collect(Bloc_poubelle::getBlocPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'poubelle' => $data[0]['poubelle'],
                "etage_etablissement_id" => $data[0]['etage_etablissement_id'],
                "etage" => $data[0]['etage'],
                "bloc_etabl" => $data[0]['bloc_etabl'],
                "etablissement" => $data[0]['etablissement'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPoubelleEtablissement/blocPoubelle', $liste);
            return $pdf->download('bloc-poubelle.pdf');
        }
    }
    public function pdfAllBlocPoubelle(){
        $bloc_poubelle = Bloc_poubelle::all();
        if (is_null($bloc_poubelle)) {
            return $this->handleError('bloc poubelle n\'existe pas!');
        }else{
            $p= Bloc_poubelleResource::collection( $bloc_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPoubelleEtablissement/blocPoubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('bloc-poubelle.pdf');
        }
    }
}
