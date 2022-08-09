<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_etablissement as Responsable_etablissementResource;
use App\Models\Responsable_etablissement;
use App\Http\Requests\GestionCompte\ResponsableEtablissementRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use Illuminate\Support\Facades\Hash;

class ResponsableEtablissementController extends BaseController{
    public function index(){
        $responsableEtablissement = Responsable_etablissement::all();
        return $this->handleResponse(Responsable_etablissementResource::collection($responsableEtablissement), 'Affichage des responsable Etablissement!');
    }

    public function store(ResponsableEtablissementRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/responsable_etablissement';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $responsableEtablissement= Responsable_etablissement::create($input);
        return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable Etablissement crée!');
    }
    public function show($id){
        $responsableEtablissement = Responsable_etablissement::find($id);
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable Etablissement existe.');
        }
    }
    public function update(ResponsableEtablissementRequest $request, Responsable_etablissement $responsableEtablissement) {
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'responsable_etablissement/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $responsableEtablissement->update($input);
        return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable Etablissement modifié!');
    }
    public function destroy($id) {
        $responsableEtablissement = Responsable_etablissement::find($id);
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }
        else{
            if($responsableEtablissement->photo){
                unlink(public_path('storage\images\responsable_etablissement\\').$responsableEtablissement->photo );
            }
            $responsableEtablissement->delete();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable Etablissement supprimé!');
     }
    }
}
