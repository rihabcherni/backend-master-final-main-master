<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud;

use App\Exports\ViderPoubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\ViderPoubelle;
use App\Models\Vider_poubelle;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class ViderPoubelleGestionnaireController extends BaseController{
    public function exportInfoViderPoubelleExcel(){
        return Excel::download(new ViderPoubelleExport  , 'vider-poubelle-liste.xlsx');
    }

    public function exportInfoViderPoubelleCSV(){
        return Excel::download(new ViderPoubelleExport, 'vider-poubelle-liste.csv');
    }
    public function pdfViderPoubelle($id){
        $viderPoubelle = Vider_poubelle::find($id);
        if (is_null($viderPoubelle)) {
            return $this->handleError('vider poubelle n\'existe pas!');
        }else{
            $data= collect(Vider_poubelle::getViderPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],

                "poubelle_id" => $data[0]['poubelle_id'],
                "poubelle_nom" => $data[0]['poubelle_nom'],
                "type_poubelle" => $data[0]['type_poubelle'],
                "etat_lors_vidage" => $data[0]['etat_lors_vidage'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "etage" => $data[0]['etage'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "etablissement" => $data[0]['etablissement'],
                "camion_id" => $data[0]['camion_id'],
                "camion_matricule" => $data[0]['camion_matricule'],
                "date_depot" => $data[0]['date_depot'],
                "quantite_depose" => $data[0]['quantite_depose'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/viderPoubelle', $liste);
            return $pdf->download('historique-vider-poubelle.pdf');
        }
    }
    public function pdfAllViderPoubelle(){
        $viderPoubelle = Vider_poubelle::all();
        if (is_null($viderPoubelle)) {
            return $this->handleError('vider poubelle n\'existe pas!');
        }else{
            $p= ViderPoubelle::collection( $viderPoubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/viderPoubelle', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('historique-vider-poubelle.pdf');
        }
    }
}
