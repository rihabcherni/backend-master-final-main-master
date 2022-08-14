<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;
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
    public function exportInfoClientDechetExcel(){
        return Excel::download(new ClientDechetExport  , 'client-dechet-liste.xlsx');
    }

    public function exportInfoClientDechetCSV(){
        return Excel::download(new ClientDechetExport, 'client-dechet-liste.csv');
    }

    public function pdfClientDechet($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            $data= collect(Client_dechet::getClientDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'poubelle_id_resp' =>   $data[0]['poubelle_id_resp'],

                "etablissement" => $data[0]['etablissement'],
                "etablissement_id" =>  $data[0]['etablissement_id'],
                "nom" => $data[0]['nom'],
                "nom_poubelle_responsable" => $data[0]['nom_poubelle_responsable'],
                "type" => $data[0]['type'],
                "Etat" => $data[0]['Etat'],
                "quantite" => $data[0]['quantite'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "bloc_poubelle_id_resp" => $data[0]['bloc_poubelle_id_resp'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],

                "etage" => $data[0]['etage'],
                "etage_id" => $data[0]['etage_id'],
                "qrcode" => $data[0]['qrcode'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionCompte/clientDechet', $liste);
            return $pdf->download('client-dechet.pdf');
        }
    }
    public function pdfAllClientDechet(){
        $client = Client_dechet::all();
        if (is_null($client)) {
            return $this->handleError('client dechet n\'existe pas!');
        }else{
            $p= Client_dechetResource::collection( $client);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionCompte/clientDechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('client-dechet.pdf');
        }
    }
}
