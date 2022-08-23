<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\TransportDechet;
use App\Exports\TransportDechet\DepotExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\TransportDechet\Depot as DepotResource;
use App\Models\Depot;
use App\Http\Requests\TransportDechet\DepotRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class DepotController extends BaseController{
    public function index(){
        $depot = Depot::all();
        return $this->handleResponse(DepotResource::collection($depot), 'affichage Depots!');
    }
    public function store(DepotRequest $request){
        $input = $request->all();
        $depot = Depot::create($input);
        return $this->handleResponse(new DepotResource($depot), 'depot crée!');
    }
    public function show($id){
        $depot = Depot::find($id);
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            return $this->handleResponse(new DepotResource($depot), 'depot existe.');
        }
    }
    public function update(DepotRequest $request, Depot $depot){
        $input = $request->all();
        $depot->update($input);
        return $this->handleResponse(new DepotResource($depot), 'depot modifié!');
    }
    public function destroy($id){
        $depot =Depot::find($id);
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }
        else{
            $depot->delete();
            return $this->handleResponse(new DepotResource($depot), 'depot supprimé!');
        }
    }
    public function hdelete( $id) {
        $depot = Depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $depot->forceDelete();
            return $this->handleResponse(new DepotResource($depot), 'depot supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $depots = Depot::onlyTrashed()->get();
        foreach($depots as $depot){
            $depot->forceDelete();
        }
        return $this->handleResponse(DepotResource::collection($depots), 'tous depot supprimés définitivement');
    }
    public function restore( $id) {
        $depot = Depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        } else{
            $depot->restore();
            return $this->handleResponse(new DepotResource($depot), 'depot supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $depots= Depot::onlyTrashed()->get();
        foreach($depots as $depot){
            $depot->restore();
        }
        return $this->handleResponse(DepotResource::collection($depots), 'tous depot restore');
    }
    public function listeSuppression(){
        $depot = Depot::onlyTrashed()->get();
        return $this->handleResponse(DepotResource::collection($depot), 'affichage des depot supprimés');
    }
    public function exportInfoExcel(){
        return Excel::download(new DepotExport, 'depot-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new DepotExport, 'depot-liste.csv');
    }
    public function pdf($id){
        $depot = Depot::find($id);
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $data= collect(Depot::getDepotById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "zone_depot_id"=> $data[0]['zone_depot_id'],
                "zone_depot"=> $data[0]['zone_depot'],
                "camion"=> $data[0]['camion'],
                "ouvrier"=> $data[0]['ouvrier'],
                "zone_travail"=> $data[0]['zone_travail'],
                "camion_id"=> $data[0]['camion_id'],
                "date_depot"=> $data[0]['date_depot'],
                "quantite_depose_plastique"=> $data[0]['quantite_depose_plastique'],
                "quantite_depose_papier"=> $data[0]['quantite_depose_papier'],
                "quantite_depose_composte"=> $data[0]['quantite_depose_composte'],
                "quantite_depose_canette"=> $data[0]['quantite_depose_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/TransportDechet/depot', $liste);
            return $pdf->download('depot.pdf');
        }
    }
    public function pdfAll(){
        $depot = Depot::all();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $p= DepotResource::collection( $depot);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/TransportDechet/depot', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('depot.pdf');
        }
    }
    public function pdfAllTrashed(){
        $depot = Depot::onlyTrashed()->get();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $p= DepotResource::collection( $depot);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/TransportDechet/depot', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('depot-supprimes.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $depot = Depot::withTrashed()->where('id' ,  $id )->first();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $data= collect(Depot::getDepotByIdTrashed($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "zone_depot_id"=> $data[0]['zone_depot_id'],
                "zone_depot"=> $data[0]['zone_depot'],
                "camion"=> $data[0]['camion'],
                "ouvrier"=> $data[0]['ouvrier'],
                "zone_travail"=> $data[0]['zone_travail'],
                "camion_id"=> $data[0]['camion_id'],
                "date_depot"=> $data[0]['date_depot'],
                "quantite_depose_plastique"=> $data[0]['quantite_depose_plastique'],
                "quantite_depose_papier"=> $data[0]['quantite_depose_papier'],
                "quantite_depose_composte"=> $data[0]['quantite_depose_composte'],
                "quantite_depose_canette"=> $data[0]['quantite_depose_canette'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
                'deleted_at' => $data[0]['deleted_at'],
            ];
            $pdf = Pdf::loadView('pdf/Delete/unique/TransportDechet/depot', $liste);
            return $pdf->download('depot-supprime.pdf');
            }
        }
}

