<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;

use App\Exports\GestionPoubelleEtablissements\EtablissementExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Etablissement as EtablissementResource;
use App\Models\Etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\EtablissementRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class EtablissementController extends BaseController{
    public function index(){
        $etablissement = Etablissement::all();
        return $this->handleResponse(EtablissementResource::collection($etablissement), 'Affichage des etablissements!');
    }
    public function store(EtablissementRequest $request){
        $input = $request->all();
        $etablissement = Etablissement::create($input);
        return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement crée!');
    }
    public function show($id){
        $etablissement = Etablissement::find($id);
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement existante.');
        }
    }
    public function update(EtablissementRequest $request, Etablissement $etablissement){
        $input = $request->all();
        $etablissement->update($input);
        return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement modifié!');
    }
    public function destroy($id){
        $etablissement =Etablissement::find($id);
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }
        else{
            $etablissement->delete();
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement supprimé!');
        }
    }
    public function hdelete( $id) {
        $etablissement = Etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $etablissement->forceDelete();
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $etablissements = Etablissement::onlyTrashed()->get();
        foreach($etablissements as $etablissement){
            $etablissement->forceDelete();
        }
        return $this->handleResponse(EtablissementResource::collection($etablissements), 'tous etablissements supprimés définitivement');
    }
    public function restore( $id) {
        $etablissement = Etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        } else{
            $etablissement->restore();
            return $this->handleResponse(new EtablissementResource($etablissement), 'etablissement supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $etablissements= Etablissement::onlyTrashed()->get();
        foreach($etablissements as $etablissement){
            $etablissement->restore();
        }
        return $this->handleResponse(EtablissementResource::collection($etablissements), 'tous etablissements restore');
    }
    public function listeSuppression(){
        $etablissement = Etablissement::onlyTrashed()->get();
        return $this->handleResponse(EtablissementResource::collection($etablissement), 'affichage des etablissements supprimés');
    }
    public function exportInfoExcel(){
        return Excel::download(new EtablissementExport , 'etablissement-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new EtablissementExport, 'etablissement-liste.csv');
    }
    public function pdf($id){
        $etablissement = Etablissement::find($id);
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $data= collect(Etablissement::getEtablissementById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "region" => $data[0]['region'],
                "zone_travail_id" => $data[0]['zone_travail_id'],
                "camion_id" => $data[0]['camion_id'],
                "nom_etablissement" => $data[0]['nom_etablissement'],
                "niveau_etablissement" => $data[0]['niveau_etablissement'],
                "type_etablissement" => $data[0]['type_etablissement'],
                "nbr_personnes" => $data[0]['nbr_personnes'],
                "url_map" => $data[0]['url_map'],
                "adresse" => $data[0]['adresse'],
                "longitude" => $data[0]['longitude'],
                "latitude" => $data[0]['latitude'],
                "quantite_dechets_plastique" => $data[0]['quantite_dechets_plastique'],
                "quantite_dechets_composte" => $data[0]['quantite_dechets_composte'],
                "quantite_dechets_papier" => $data[0]['quantite_dechets_papier'],
                "quantite_dechets_canette" => $data[0]['quantite_dechets_canette'],
                "quantite_plastique_mensuel" => $data[0]['quantite_plastique_mensuel'],
                "quantite_papier_mensuel" => $data[0]['quantite_papier_mensuel'],
                "quantite_composte_mensuel" => $data[0]['quantite_composte_mensuel'],
                "quantite_canette_mensuel" => $data[0]['quantite_canette_mensuel'],


                "bloc_etablissements" => $data[0]['bloc_etablissements'],
                "etage" => $data[0]['etage'],
                "bloc_poubelle" => $data[0]['bloc_poubelle'],
                "camion" => $data[0]['camion'],
                "details_blocs" => $data[0]['details_blocs'],
                "responsable_etablissement" => $data[0]['responsable_etablissement'],

                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPoubelleEtablissement/etablissement', $liste)->setPaper('a3', 'landscape');
            return $pdf->download('etablissement.pdf');
        }
    }
    public function pdfAll(){
        $etablissement = Etablissement::all();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $p= EtablissementResource::collection( $etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPoubelleEtablissement/etablissement', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('etablissement.pdf');
        }
    }
    public function pdfAllTrashed(){
        $etablissement = Etablissement::onlyTrashed()->get();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $p= EtablissementResource::collection( $etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionPoubelleEtablissement/etablissement', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('etablissement-supprimes.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $etablissement = Etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $data= collect(Etablissement::getEtablissementByIdTrashed($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "region" => $data[0]['region'],
                "zone_travail_id" => $data[0]['zone_travail_id'],
                "camion_id" => $data[0]['camion_id'],
                "nom_etablissement" => $data[0]['nom_etablissement'],
                "niveau_etablissement" => $data[0]['niveau_etablissement'],
                "type_etablissement" => $data[0]['type_etablissement'],
                "nbr_personnes" => $data[0]['nbr_personnes'],
                "url_map" => $data[0]['url_map'],
                "adresse" => $data[0]['adresse'],
                "longitude" => $data[0]['longitude'],
                "latitude" => $data[0]['latitude'],
                "quantite_dechets_plastique" => $data[0]['quantite_dechets_plastique'],
                "quantite_dechets_composte" => $data[0]['quantite_dechets_composte'],
                "quantite_dechets_papier" => $data[0]['quantite_dechets_papier'],
                "quantite_dechets_canette" => $data[0]['quantite_dechets_canette'],
                "quantite_plastique_mensuel" => $data[0]['quantite_plastique_mensuel'],
                "quantite_papier_mensuel" => $data[0]['quantite_papier_mensuel'],
                "quantite_composte_mensuel" => $data[0]['quantite_composte_mensuel'],
                "quantite_canette_mensuel" => $data[0]['quantite_canette_mensuel'],

                "bloc_etablissements" => $data[0]['bloc_etablissements'],
                "etage" => $data[0]['etage'],
                "bloc_poubelle" => $data[0]['bloc_poubelle'],
                "camion" => $data[0]['camion'],
                "details_blocs" => $data[0]['details_blocs'],
                "responsable_etablissement" => $data[0]['responsable_etablissement'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
                'deleted_at' => $data[0]['deleted_at'],
            ];
            $pdf = Pdf::loadView('pdf/Delete/unique/GestionPoubelleEtablissement/etablissement', $liste)->setPaper('a3', 'landscape');;
            return $pdf->download('etablissement-supprime.pdf');
            }
        }
}

