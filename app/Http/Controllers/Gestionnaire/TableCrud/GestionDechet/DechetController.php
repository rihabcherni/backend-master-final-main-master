<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;

use App\Exports\GestionDechet\DechetExport;
use App\Models\Commande_dechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;
use App\Models\Dechet;
use App\Http\Requests\GestionDechet\DechetRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
Use \Carbon\Carbon;
use App\Models\Detail_commande_dechet;
class DechetController extends BaseController{
    public function index(){
        $dechet = Dechet::all();
        return $this->handleResponse(DechetResource::collection($dechet), 'tous les dechets!');
    }
    public function store(DechetRequest $request){
        $input = $request->all();
        $dechet = Dechet::create($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet crée!');
    }
    public function show($id){
        $dechet = Dechet::find($id);
        if (count($dechet)==0) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new DechetResource($dechet), 'dechet existante.');
        }
    }
    public function update(DechetRequest $request, Dechet $dechet){
        $input = $request->all();
        $dechet->update($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet modifié!');
    }
    public function destroy($id) {
        $dechet =Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }
        else{
            $dechet->delete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        }
    }
    public function panier(Request $request){
        $myArray = array();
        $json = utf8_decode($request->commande);
        $data = json_decode($json,true);
        $bool = false;
        // $len = count($data);

        // $id_dechets = $data[0]['type']['id'];
        // $qte_dechets = data[0]['qte'];

        // $id = $request->id;
        // $prix_totals = json_decode($request->prix_total);

        $cmd=Commande_dechet::create([
            'client_dechet_id' => $request->id_client,
            "type_paiment"=> $request->type_paiment,
            'montant_total'=>$request->montant_total,
            'date_commande' => Carbon::now()->translatedFormat('H:i:s j F Y')
        ]);

        if(count($data)>1){
            for ($i=0; $i <count($data) ; $i++){
                Detail_commande_dechet::create([
                    'commande_dechet_id' => $cmd->id,
                    'dechet_id' => $data[$i]['type']['id'],
                    'quantite' => $data[$i]['qte'],
                ]);
            }
        }else{
            Detail_commande_dechet::create([
                'commande_dechet_id' => $cmd->id,
                'dechet_id' => $data[0]['type']['id'],
                'quantite' => $data[0]['qte'],
            ]);
        }

        return response([
            // "prix_total" => $prix_totals[0]->prix_total,
            // "data" => $data,
            // "myArrayCount" => count($myArray),
            // "myArray" => $myArray,
            'cmd' => $cmd,
            'id_cmd' => $cmd->id,
            'bool' => $bool
        ]);
    }
    public function exportInfoDechetExcel(){
        return Excel::download(new DechetExport  , 'dechet-liste.xlsx');
    }

    public function exportInfoDechetCSV(){
        return Excel::download(new DechetExport, 'dechet-liste.csv');
    }
    public function pdfDechet($id){
        $dechet = Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            $data= collect(Dechet::getDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "type_dechet"  => $data[0]['type_dechet'],
                "prix_unitaire" => $data[0]['prix_unitaire'],
                "pourcentage_remise" => $data[0]['pourcentage_remise'],
                "photo" => $data[0]['photo'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionDechet/Dechet', $liste);
            return $pdf->download('dechet.pdf');
        }
    }
    public function pdfAllDechet(){
        $dechet = Dechet::all();
        if (is_null($dechet)) {
            return $this->handleError('Dechet n\'existe pas!');
        }else{
            $p= DechetResource::collection( $dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionDechet/Dechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('dechet.pdf');
        }
    }
}
