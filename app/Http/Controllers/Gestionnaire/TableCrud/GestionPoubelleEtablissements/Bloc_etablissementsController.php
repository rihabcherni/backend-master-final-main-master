<?php

namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;

use App\Exports\GestionPoubelleEtablissements\Bloc_etablissementExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_etablissements as Bloc_etablissementsResource;
use App\Models\Bloc_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Bloc_etablissementsRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Bloc_etablissementsController extends BaseController{
    public function index(){
        $bloc_etablissement = Bloc_etablissement::all();
        return $this->handleResponse(Bloc_etablissementsResource::collection($bloc_etablissement), 'Affichage des blocs etablissement!');
    }
    public function store(Bloc_etablissementsRequest $request){
        $input = $request->all();
        $bloc_etablissement = Bloc_etablissement::create($input);
        return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'Block etablissement crée!');
    }
    public function show($id){
        $bloc_etablissement = Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement existante.');
        }
    }
    public function update(Bloc_etablissementsRequest $request, Bloc_etablissement $bloc_etablissement){
        $input = $request->all();
        $bloc_etablissement->update($input);
        return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement modifié!');
    }
    public function destroy($id){
        $bloc_etablissement =Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }
        else{
            $bloc_etablissement->delete();
            return $this->handleResponse(new Bloc_etablissementsResource($bloc_etablissement), 'bloc etablissement supprimé!');
        }
    }
    public function exportInfoBlocEtablissementExcel(){
        return Excel::download(new Bloc_etablissementExport  , 'bloc-etablissement-liste.xlsx');
    }

    public function exportInfoBlocEtablissementCSV(){
        return Excel::download(new Bloc_etablissementExport, 'bloc-etablissement-liste.csv');
    }

    public function pdfBlocEtablissement($id){
        $bloc_etablissement = Bloc_etablissement::find($id);
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }else{
            $data= collect(Bloc_etablissement::getBlocEtablissementById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'nombre_etage' => $data[0]['nombre_etage'],
                'etage_etablissements' => $data[0]['etage_etablissements'],
                "etablissement"=> $data[0]['etablissement'],
                "etablissement_id"=> $data[0]['etablissement_id'],
                "nom_bloc_etablissement"=> $data[0]['nom_bloc_etablissement'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionPoubelleEtablissement/BlocEtablissement', $liste);
            return $pdf->download('bloc-etablissement.pdf');
        }
    }
    public function pdfAllBlocEtablissement(){
        $bloc_etablissement = Bloc_etablissement::all();
        if (is_null($bloc_etablissement)) {
            return $this->handleError('bloc etablissement n\'existe pas!');
        }else{
            $p= Bloc_etablissementsResource::collection( $bloc_etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPoubelleEtablissement/BlocEtablissement', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('bloc-etablissement.pdf');
        }
    }
}

