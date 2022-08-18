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
    public function exportInfoEtablissementExcel(){
        return Excel::download(new EtablissementExport , 'etablissement-liste.xlsx');
    }
    public function exportInfoEtablissementCSV(){
        return Excel::download(new EtablissementExport, 'etablissement-liste.csv');
    }
    public function pdfEtablissement($id){
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
            $pdf = Pdf::loadView('pdf/unique/GestionPoubelleEtablissement/etablissement', $liste)->setPaper('a4', 'landscape');
            return $pdf->download('etablissement.pdf');
        }
    }
    public function pdfAllEtablissement(){
        $etablissement = Etablissement::all();
        if (is_null($etablissement)) {
            return $this->handleError('etablissement n\'existe pas!');
        }else{
            $p= EtablissementResource::collection( $etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPoubelleEtablissement/etablissement', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('etablissement.pdf');
        }
    }
}
