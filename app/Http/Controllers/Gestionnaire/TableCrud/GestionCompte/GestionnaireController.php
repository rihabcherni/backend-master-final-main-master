<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Gestionnaire as GestionnaireResource;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Requests\GestionCompte\GestionnaireRequest;
class GestionnaireController extends BaseController{
    public function index(){
        $gestionnaire = Gestionnaire::all();
        return $this->handleResponse(GestionnaireResource::collection($gestionnaire),'affichage des gestionnaire');
    }
    public function store(GestionnaireRequest $request){
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/gestionnaire';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $gestionnaire= Gestionnaire::create($input);
        return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire crée!');
    }
    public function show($id) {
        $gestionnaire = Gestionnaire::find($id);
        if (is_null($gestionnaire)) {
            return $this->handleError('Gestionnaire n\'existe pas!');
        }else{
            return $this->handleResponse(new GestionnaireResource($gestionnaire),'gestionnaire existante.');
        }
    }
    public function update(GestionnaireRequest $request,Gestionnaire $gestionnaire){
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'gestionnaire/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }

        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $gestionnaire->update($input);
        return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire modifié avec succes');
    }
    public function destroy($id) {
        $gestionnaire = Gestionnaire::find($id);
        if (is_null($gestionnaire)) {
            return $this->handleError('gestionnaire n\'existe pas!');
        }
        else{
            if($gestionnaire->photo){
                unlink(public_path('storage\images\gestionnaire\\').$gestionnaire->photo );
            }
            $gestionnaire->delete();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé!');
        }
    }
    public function hdelete( $id) {
        $gestionnaire = Gestionnaire::withTrashed()->where('id' ,  $id )->first();
        $gestionnaire->forceDelete();
        return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé  avec force!');
    }
    public function restore( $id) {
        $gestionnaire = Gestionnaire::withTrashed()->where('id' ,  $id )->first();
        $gestionnaire->restore();
        return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé avec retour!');
    }
    public function restoreAll(){
        $gestionnaires= Gestionnaire::onlyTrashed()->get();
        foreach($gestionnaires as $gestionnaire){
            $gestionnaire->restore();
        }
        return $this->handleResponse(GestionnaireResource::collection($gestionnaires), 'tous gestionnaires trashed');
    }
    public function gestionnairetrash(){
        $gestionnaire = Gestionnaire::onlyTrashed()->get();
        return $this->handleResponse(GestionnaireResource::collection($gestionnaire), 'affichage des gestionnaires');
    }
/*
    public function storeGestionnaire(Request $request){
        $nom=$request->nom;
        $prenom=$request->prenom;
        $CIN=$request->CIN;
        $numero_telephone=$request->numero_telephone;
        $email=$request->email;
        $mot_de_passe=$request->mot_de_passe;
        $image=$request->file('file');

        $imageName=time(). '.' .$image->extension();
        $image->move(public_path('images'),$imageName);
        $gestionnaire =new Gestionnaire();
        $gestionnaire->nom = $nom;
        $gestionnaire->prenom = $prenom;
        $gestionnaire->CIN = $CIN;
        $gestionnaire->numero_telephone = $numero_telephone;
        $gestionnaire->email = $email;
        $gestionnaire->mot_de_passe =  Hash::make($mot_de_passe);

       // $gestionnaire->photo = $imageName;
        $gestionnaire->save();
        return $this->handleResponse(new GestionnaireResource($gestionnaire), 'success_added','gestionnaire record has been inserted');
    }

    public function updateGestionnaire(Request $request){
        $nom=$request->nom;
        $prenom=$request->prenom;
        $CIN=$request->CIN;
        $numero_telephone=$request->numero_telephone;
        $email=$request->email;
        $mot_de_passe=$request->mot_de_passe;
        $image=$request->file('file');

        $imageName=time(). '.' .$image->extension();
        $image->move(public_path('images'),$imageName);
        $gestionnaire = Gestionnaire::find($request->id);
        $gestionnaire->nom = $nom;
        $gestionnaire->prenom = $prenom;
        $gestionnaire->CIN = $CIN;
        $gestionnaire->numero_telephone = $numero_telephone;
        $gestionnaire->email = $email;
        $gestionnaire->mot_de_passe = $mot_de_passe;
        $gestionnaire->photo = $imageName;
        $gestionnaire->save();
        return back()->with('success_update','gestionnaire record has been  updated');
    }
    public function deleteGestionnaire($id){
        $gestionnaire=Gestionnaire::find($id);
        unlink(public_path('images').'/'.$gestionnaire->profileimage );
        $gestionnaire->delete();
        return back()->with('success_delete','gestionnaire record has been  delete');
    }
    public function autocomplete(Request $request){
        $datas=Gestionnaire::select('nom')
                        ->where('nom','LIKE',"%{$request->terms}%")
                        ->get();
        return response()->json($datas);
    }

*/
}
