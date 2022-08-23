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
        return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'Etage etablissement crée!');
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
    public function hdelete( $id) {
        $etage_etablissement = Etage_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $etage_etablissement->forceDelete();
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $etage_etablissements = Etage_etablissement::onlyTrashed()->get();
        foreach($etage_etablissements as $etage_etablissement){
            $etage_etablissement->forceDelete();
        }
        return $this->handleResponse(Etage_etablissementsResource::collection($etage_etablissements), 'tous étages etablissements supprimés définitivement');
    }
    public function restore( $id) {
        $etage_etablissement = Etage_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        } else{
            $etage_etablissement->restore();
            return $this->handleResponse(new Etage_etablissementsResource($etage_etablissement), 'etage etablissement supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $etage_etablissements= Etage_etablissement::onlyTrashed()->get();
        foreach($etage_etablissements as $etage_etablissement){
            $etage_etablissement->restore();
        }
        return $this->handleResponse(Etage_etablissementsResource::collection($etage_etablissements), 'tous étages etablissements restore');
    }
    public function listeSuppression(){
        $etage_etablissement = Etage_etablissement::onlyTrashed()->get();
        return $this->handleResponse(Etage_etablissementsResource::collection($etage_etablissement), 'affichage des étages etablissements supprimés');
    }
    public function exportInfoExcel(){
        return Excel::download(new Etage_etablissementExport  , 'etage-etablissement-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Etage_etablissementExport, 'etage-etablissement-liste.csv');
    }
    public function pdf($id){
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
                "bloc_poubelles" => $data[0]['bloc_poubelles'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPoubelleEtablissement/etageEtablissement', $liste);
            return $pdf->download('etage-etablissement.pdf');
        }
    }
    public function pdfAll(){
        $etage_etablissement = Etage_etablissement::all();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $p= Etage_etablissementsResource::collection( $etage_etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPoubelleEtablissement/etageEtablissement', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('etage-etablissement.pdf');
        }
    }
    public function pdfAllTrashed(){
        $etage_etablissement = Etage_etablissement::onlyTrashed()->get();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $p= Etage_etablissementsResource::collection( $etage_etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionPoubelleEtablissement/etageEtablissement', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('etage-etablissement-supprimes.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $etage_etablissement = Etage_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etage_etablissement)) {
            return $this->handleError('etage etablissement n\'existe pas!');
        }else{
            $data= collect(Etage_etablissement::getEtageEtablissementByIdTrashed($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "etablissement" => $data[0]['etablissement'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],
                "nom_etage_etablissement" => $data[0]['nom_etage_etablissement'],
                "bloc_poubelles" => $data[0]['bloc_poubelles'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
                'deleted_at' => $data[0]['deleted_at'],
            ];
            $pdf = Pdf::loadView('pdf/Delete/unique/GestionPoubelleEtablissement/etageEtablissement', $liste);
            return $pdf->download('etage-etablissement-supprime.pdf');
            }
        }
}
