<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Ouvrier as OuvrierResource;
use App\Models\Ouvrier;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Requests\GestionCompte\OuvrierRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class OuvrierController extends BaseController{
    public function index(){
        $ouvrier = Ouvrier::all();
        return $this->handleResponse(OuvrierResource::collection($ouvrier), 'Affichage des Ouvriers!');
    }

    public function store(OuvrierRequest $request){
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $ouvrier = Ouvrier::create($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier crée!');
    }

    public function show($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier existe.');
        }
    }
    public function update(OuvrierRequest $request, Ouvrier $ouvrier){
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }

        $ouvrier->update($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier modifié!');
    }
    public function destroy($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }
        else{
            if($ouvrier->photo){
                unlink(public_path('storage\images\ouvrier\\').$ouvrier->photo );
            }
            $ouvrier->delete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier supprimé!');
        }
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
