<?php
namespace App\Http\Controllers\API\GestionDechet;
use App\Models\Commande_dechet;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;
use App\Models\Dechet;
use App\Http\Requests\GestionDechet\DechetRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
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
}
