<?php

namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;

use App\Exports\GestionPoubelleEtablissements\Etage_etablissementExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Etage_etablissements as Etage_etablissementsResource;
use App\Models\Etage_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\Etage_etablissementsRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Etage_etablissementsControlller extends BaseController{
    public function index(){
        $etage_etablissement = Etage_etablissement::all();
        return $this->handleResponse(Etage_etablissementsResource::collection($etage_etablissement), 'Affichage des etages etablissement!');
    }
    public function store(Etage_etablissementsRequest $request){
        $input = $request->all();
        $etage_etablissement = Etage_etablissement::create($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'Block etablissement crée!');
    }
    public function show($id){
        $etage_etablissement = Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement existante.');
        }
    }
    public function update(Etage_etablissementsRequest $request, Etage_etablissement $etage_etablissement){
        $input = $request->all();
        $etage_etablissement->update($input);
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement modifié!');
    }
    public function destroy($id){
        $etage_etablissement =Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }
        else{
            $etage_etablissement->delete();
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement supprimé!');
        }
    }
    public function exportInfoEtageEtablissementExcel(){
        return Excel::download(new Etage_etablissementExport  , 'etage-etablissement-liste.xlsx');
    }
    public function exportInfoEtageEtablissementCSV(){
        return Excel::download(new Etage_etablissementExport, 'etage-etablissement-liste.csv');
    }
    public function pdfEtageEtablissement($id){
        $etage_etablissement = Etage_etablissement::find($id);
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $data= collect(Etage_etablissement::getEtageEtablissementById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "etablissement" => $data[0]['etablissement'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],
                "nom_etage_etablissement" => $data[0]['nom_etage_etablissement'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionPoubelleEtablissement/etageEtablissement', $liste);
            return $pdf->download('etage-etablissement.pdf');
        }
    }
    public function pdfAllEtageEtablissement(){
        $etage_etablissement = Etage_etablissement::all();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $p= Etage_etablissementsResource::collection( $etage_etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPoubelleEtablissement/etageEtablissement', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('etage-etablissement.pdf');
        }
    }
}


