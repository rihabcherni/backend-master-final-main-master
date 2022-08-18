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
    public function exportInfoDepotExcel(){
        return Excel::download(new DepotExport, 'depot-liste.xlsx');
    }
    public function exportInfoDepotCSV(){
        return Excel::download(new DepotExport, 'depot-liste.csv');
    }

    public function pdfDepot($id){
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
            $pdf = Pdf::loadView('pdf/unique/TransportDechet/depot', $liste);
            return $pdf->download('depot.pdf');
        }
    }
    public function pdfAllDepot(){
        $depot = Depot::all();
        if (is_null($depot)) {
            return $this->handleError('depot n\'existe pas!');
        }else{
            $p= DepotResource::collection( $depot);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/TransportDechet/depot', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('depot.pdf');
        }
    }
}
