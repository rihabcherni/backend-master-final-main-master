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
    public function hdelete( $id) {
        $zone_travail = Zone_travail::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $zone_travail->forceDelete();
            return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $zone_travails = Zone_travail::onlyTrashed()->get();
        foreach($zone_travails as $zone_travail){
            $zone_travail->forceDelete();
        }
        return $this->handleResponse(Zone_travailResource::collection($zone_travails), 'tous zones de travail  supprimés définitivement');
    }
    public function restore( $id) {
        $zone_travail = Zone_travail::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        } else{
            $zone_travail->restore();
            return $this->handleResponse(new Zone_travailResource($zone_travail), 'zone travail supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $zone_travails= Zone_travail::onlyTrashed()->get();
        foreach($zone_travails as $zone_travail){
            $zone_travail->restore();
        }
        return $this->handleResponse(Zone_travailResource::collection($zone_travails), 'tous zones de travail  restore');
    }
    public function listeSuppression(){
        $zone_travail = Zone_travail::onlyTrashed()->get();
        return $this->handleResponse(Zone_travailResource::collection($zone_travail), 'affichage des zones de travail  supprimés');
    }
    public function exportInfoExcel(){
        return Excel::download(new Zone_travailExport  , 'zone-travail-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Zone_travailExport, 'zone-travail-liste.csv');
    }
    public function pdf($id){
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
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPoubelleEtablissement/zoneTravail', $liste);
            return $pdf->download('zone-travail.pdf');
        }
    }
    public function pdfAll(){
        $zone_travail = Zone_travail::all();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $p= Zone_travailResource::collection( $zone_travail);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPoubelleEtablissement/zoneTravail', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('zone-travail.pdf');
        }
    }
    public function pdfAllTrashed(){
        $zone_travail = Zone_travail::onlyTrashed()->get();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $p= Zone_travailResource::collection( $zone_travail);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionPoubelleEtablissement/zoneTravail', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('zone-travail-supprimes.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $zone_travail = Zone_travail::withTrashed()->where('id' ,  $id )->first();
        if (is_null($zone_travail)) {
            return $this->handleError('zone travail n\'existe pas!');
        }else{
            $data= collect(Zone_travail::getZoneTravailByIdTrashed($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "region" => $data[0]['region'],
                "quantite_total_collecte_plastique" => $data[0]['quantite_total_collecte_plastique'],
                "quantite_total_collecte_composte" => $data[0]['quantite_total_collecte_composte'],
                "quantite_total_collecte_papier" => $data[0]['quantite_total_collecte_papier'],
                "quantite_total_collecte_canette" => $data[0]['quantite_total_collecte_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
                'deleted_at' => $data[0]['deleted_at'],
            ];
            $pdf = Pdf::loadView('pdf/Delete/unique/GestionPoubelleEtablissement/zoneTravail', $liste);
            return $pdf->download('zone-travail-supprime.pdf');
            }
        }
}

