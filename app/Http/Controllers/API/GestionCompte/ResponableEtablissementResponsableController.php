<?php
namespace App\Http\Controllers\API\GestionCompte;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_etablissement as Responsable_etablissementResource;
use App\Models\Responsable_etablissement;
use App\Http\Requests\GestionCompte\ResponsableEtablissementRequest;
use Illuminate\Support\Facades\Hash;

class ResponableEtablissementResponsableController extends BaseController{
    public function index(){
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $responsableEtablissement = Responsable_etablissement::where('etablissement_id',$etab_id)->get();
        return $this->handleResponse(Responsable_etablissementResource::collection($responsableEtablissement), 'Affichage des responsable Etablissement!');
    }
    public function store(ResponsableEtablissementRequest $request)  {
        $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        $input = $request->all();
        $input['etablissement_id']=$etab_id;
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/responsable_etablissement';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
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
    public function update(ResponsableEtablissementRequest $request, $id) {
        $input = $request->all();
        $responsableEtablissement = Responsable_etablissement::find($id);
        // return $responsableEtablissement;
        // $etab_id=auth()->guard('responsable_etablissement')->user()->etablissement_id;
        // $input['etablissement_id']=$etab_id;
        if ($image = $request->file('photo')) {
            $destinationPath = 'responsable_etablissement/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{ unset($input['photo']); }
        if(!($request->mot_de_passe==null)){ $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);}
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
