<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_personnel as Responsable_personnelResource;
use App\Http\Requests\GestionCompte\ResponsablePersonnelRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Models\Responsable_personnel;
use Illuminate\Support\Facades\Hash;

class ResponsablePersonnelController extends BaseController{
    public function index(){
        $responsablePersonnel = Responsable_personnel::all();
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnel), 'Affichage des responsable personnel!');
    }

    public function store(ResponsablePersonnelRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/responsable_personnel';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $responsablePersonnel= Responsable_personnel::create($input);
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement crée!');
    }
    public function show($id){
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement existe.');
        }
    }
    public function update(ResponsablePersonnelRequest $request, Responsable_personnel $responsablePersonnel) {
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'responsable_personnel/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $responsablePersonnel->update($input);
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement modifié!');
    }
    public function destroy($id) {
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }
        else{
            if($responsablePersonnel->photo){
                unlink(public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo );
            }
            $responsablePersonnel->delete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement supprimé!');
     }
    }
}
