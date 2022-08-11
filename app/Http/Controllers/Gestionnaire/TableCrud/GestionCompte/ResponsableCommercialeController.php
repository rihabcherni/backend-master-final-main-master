<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_commercial as Responsable_commercialResource;
use App\Models\Responsable_commercial;
use App\Http\Requests\GestionCompte\ResponsableCommercialeRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use Illuminate\Support\Facades\Hash;

class ResponsableCommercialeController extends BaseController{
    public function index(){
        $responsablecommercial = Responsable_commercial::all();
        return $this->handleResponse(Responsable_commercialResource::collection($responsablecommercial), 'Affichage des responsable commercial!');
    }

    public function store(ResponsableCommercialeRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/responsable_commercial';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $responsablecommercial= Responsable_commercial::create($input);
        return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial crée!');
    }
    public function show($id){
        $responsablecommercial = Responsable_commercial::find($id);
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial existe.');
        }
    }
    public function update(ResponsableCommercialeRequest $request, Responsable_commercial $responsablecommercial) {
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'responsable_commercial/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $responsablecommercial->update($input);
        return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial modifié!');
    }
    public function destroy($id) {
        $responsablecommercial = Responsable_commercial::find($id);
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial n\'existe pas!');
        }
        else{
            if($responsablecommercial->photo){
                unlink(public_path('storage\images\responsable_commercial\\').$responsablecommercial->photo );
            }
            $responsablecommercial->delete();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial supprimé!');
     }
    }
}
