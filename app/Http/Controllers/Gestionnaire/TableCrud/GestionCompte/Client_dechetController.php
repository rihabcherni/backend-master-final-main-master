<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Resources\GestionCompte\Client_dechet as Client_dechetResource;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GestionCompte\Client_dechetRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
}
