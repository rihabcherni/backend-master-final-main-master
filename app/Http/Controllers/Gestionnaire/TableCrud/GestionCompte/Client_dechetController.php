<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Resources\GestionCompte\Client_dechet as Client_dechetResource;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GestionCompte\Client_dechetRequest;
use Illuminate\Support\Str;
use App\Exports\GestionCompte\ClientDechetExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class Client_dechetController extends BaseController{
    public function index(){
        $client = Client_dechet::all();
        return $this->handleResponse(Client_dechetResource::collection($client), 'Affichage des clients!');
    }
    public function store(Client_dechetRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $client= Client_dechet::create($input);
        return $this->handleResponse(new Client_dechetResource($client), 'Client crée!');
    }
    public function show($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            return $this->handleResponse(new Client_dechetResource($client), 'Client existe.');
        }
    }
    public function update(Client_dechetRequest $request, Client_dechet $client){
        $input = $request->all();
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $client->update($input);
        return $this->handleResponse(new Client_dechetResource($client), 'Client modifié!');


    }
    public function destroy($id) {
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client  n\'existe pas!');
        }
        else{
            $client->delete();
            return $this->handleResponse(new Client_dechetResource($client), 'Client supprimé!');
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
                'nom_entreprise' => $data[0]['nom_entreprise'],
                'matricule_fiscale' => $data[0]['matricule_fiscale'],
                'nom' => $data[0]['nom'],
                'prenom' => $data[0]['prenom'],
                'numero_fixe' => $data[0]['numero_fixe'],
                'adresse' => $data[0]['adresse'],
                'numero_telephone' => $data[0]['numero_telephone'],
                'email' => $data[0]['email'],
                'created_at' => $data[0]['created_at'],
                'updated_at' => $data[0]['updated_at'],
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
