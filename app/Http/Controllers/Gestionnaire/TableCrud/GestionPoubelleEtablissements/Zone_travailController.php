<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;
use App\Exports\GestionPoubelleEtablissements\Zone_travailExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Zone_travail as Zone_travailResource;
use App\Http\Requests\GestionPoubelleEtablissements\Zone_travailRequest;
use App\Models\Zone_travail;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Zone_travailController extends BaseController{
    public function index(){
        $zone_travail = Zone_travail::all();
        return $this->handleResponse(Zone_travailResource::collection($zone_travail), 'affichage de tous les zone travail!');
    }
    public function store(Zone_travailRequest $request){
        $input = $request->all();
        $input['quantite_total_collecte_plastique']=0;
        $input['quantite_total_collecte_papier']=0;
        $input['quantite_total_collecte_composte']=0;
        $input['quantite_total_collecte_canette']=0;
        $zone_travail = Zone_travail::create($input);
        return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail crée!');
    }
    public function show($id) {
        $zone_travail = Zone_travail::find($id);
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail existe.');
        }
    }
    public function update(Zone_travailRequest $request, Zone_travail $zone_travail){
        $input = $request->all();
        $zone_travail->update($input);
        return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail modifié avec succés');
    }
    public function destroy($id){
        $zone_travail =Zone_travail::find($id);
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }
        else{
            $zone_travail->delete();
            return $this->handleResponse(new Zone_travailResource($zone_travail), ' zone travail supprimé!');
        }
    }
    public function exportInfoZoneTravailExcel(){
        return Excel::download(new Zone_travailExport  , 'zone-travail-liste.xlsx');
    }
    public function exportInfoZoneTravailCSV(){
        return Excel::download(new Zone_travailExport, 'zone-travail-liste.csv');
    }
    public function pdfZoneTravail($id){
        $zone_travail = Zone_travail::find($id);
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $data= collect(Zone_travail::getZoneTravailById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "region" => $data[0]['region'],
                "quantite_total_collecte_plastique" => $data[0]['quantite_total_collecte_plastique'],
                "quantite_total_collecte_composte" => $data[0]['quantite_total_collecte_composte'],
                "quantite_total_collecte_papier" => $data[0]['quantite_total_collecte_papier'],
                "quantite_total_collecte_canette" => $data[0]['quantite_total_collecte_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionPoubelleEtablissement/zoneTravail', $liste);
            return $pdf->download('zone-travail.pdf');
        }
    }
    public function pdfAllZoneTravail(){
        $zone_travail = Zone_travail::all();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $p= Zone_travailResource::collection( $zone_travail);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPoubelleEtablissement/zoneTravail', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('zone-travail.pdf');
        }
    }
}
