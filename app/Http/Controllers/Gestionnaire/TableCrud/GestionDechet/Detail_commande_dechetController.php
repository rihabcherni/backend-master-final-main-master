<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;

use App\Exports\GestionDechet\Detail_commande_dechetExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Detail_commande_dechet as Detail_commande_dechetResource;
use App\Models\Detail_commande_dechet;
use App\Http\Requests\GestionDechet\Detail_commande_dechetRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class Detail_commande_dechetController extends BaseController{
    public function index(){
        $detail_commande = Detail_commande_dechet::all();
        return $this->handleResponse(Detail_commande_dechetResource::collection($detail_commande), 'tous les details des commandes dechet!');
    }
    public function store(Detail_commande_dechetRequest $request){
        $input = $request->all();
        $detail_commande = Detail_commande_dechet::create($input);
        return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet crée!');
    }
    public function show($id){
        $detail_commande = Detail_commande_dechet::find($id);
        if (count($detail_commande)==0) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet existante.');
        }
    }
    public function update(Detail_commande_dechetRequest $request, Detail_commande_dechet $detail_commande){
        $input = $request->all();
        $detail_commande->update($input);
        return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet modifié!');
    }
    public function destroy($id) {
        $detail_commande =Detail_commande_dechet::find($id);
        if (is_null($detail_commande)) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }
        else{
            $detail_commande->delete();
            return $this->handleResponse(new Detail_commande_dechetResource($detail_commande), 'detail commande dechet supprimé!');
        }
    }
    public function afficherDetailsDechet(Request $request){
        $detail_commande = Detail_commande_dechet::where('commande_dechet_id',$request->id)->get();
        if ( count($detail_commande)==0 ) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }else{
        return $this->handleResponse(Detail_commande_dechetResource::collection($detail_commande), 'tous les details des commandes dechet!');
        }
    }

    public function exportInfoDetailCommandeDechetExcel(){
        return Excel::download(new Detail_commande_dechetExport  , 'Detail-commande-dechet-liste.xlsx');
    }

    public function exportInfoDetailCommandeDechetCSV(){
        return Excel::download(new Detail_commande_dechetExport, 'Detail-commande-dechet-liste.csv');
    }

    public function pdfDetailCommandeDechet($id){
        $detail_commande_dechet = Detail_commande_dechet::find($id);
        if (is_null($detail_commande_dechet)) {
            return $this->handleError('detail commande dechet n\'existe pas!');
        }else{
            $data= collect(Detail_commande_dechet::getDetailCommandeDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "commande_dechet_id" => $data[0]['commande_dechet_id'],
                "type"  => $data[0]['type'],
                "quantite"  => $data[0]['quantite'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionDechet/detailCommandeDechet', $liste);
            return $pdf->download('detail-commande-dechet.pdf');
        }
    }
    public function pdfAllDetailCommandeDechet(){
        $detail_commande_dechet = Detail_commande_dechet::all();
        if (is_null($detail_commande_dechet)) {
            return $this->handleError('detail commande dechet  n\'existe pas!');
        }else{
            $p= Detail_commande_dechetResource::collection( $detail_commande_dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionDechet/detailCommandeDechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('detail-commande-dechet.pdf');
        }
    }
}
