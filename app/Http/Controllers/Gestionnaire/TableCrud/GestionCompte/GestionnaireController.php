<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\GestionnaireExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Gestionnaire as GestionnaireResource;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Http\Controllers\Authentification\SendFirstPasswordController;
use App\Http\Requests\GestionCompte\GestionnaireRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class GestionnaireController extends BaseController{
    public function index(){
        $gestionnaire = Gestionnaire::all();
        return $this->handleResponse(GestionnaireResource::collection($gestionnaire),'affichage des gestionnaire');
    }
    public function store(GestionnaireRequest $request){
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new SendFirstPasswordController;
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
        }elseif($gestionnaire->photo ==="default.jpeg" || $gestionnaire->photo === NULL){
            $gestionnaire->delete();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé!');
        } else{
            if(File::exists(('storage\images\gestionnaire\\').$gestionnaire->photo)){
                File::copy(public_path('storage\images\Gestionnaire\\').$gestionnaire->photo,
                public_path('storage\trashImages\gestionnaire\\').$gestionnaire->photo);
                unlink(public_path('storage\images\Gestionnaire\\').$gestionnaire->photo );
            }
            $gestionnaire->delete();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé!');
        }
    }
    public function hdelete( $id) {
        $gestionnaire = Gestionnaire::withTrashed()->where('id' ,  $id )->first();
        if (is_null($gestionnaire)) {
            return $this->handleError('gestionnaire n\'existe pas!');
        }elseif($gestionnaire->photo ==="default.jpeg" || $gestionnaire->photo === NULL){
            $gestionnaire->forceDelete();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé!');
        } else{
            if(File::exists(('storage\trashImages\gestionnaire\\').$gestionnaire->photo)){
                unlink(public_path('storage\trashImages\gestionnaire\\').$gestionnaire->photo );
            }
            $gestionnaire->forceDelete();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $gestionnaires = Gestionnaire::onlyTrashed()->get();
        foreach($gestionnaires as $gestionnaire){
            if($gestionnaire->photo ==="default.jpeg" || $gestionnaire->photo === NULL){
                $gestionnaire->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\gestionnaire\\').$gestionnaire->photo)){
                    unlink(public_path('storage\trashImages\gestionnaire\\').$gestionnaire->photo );
                }
                $gestionnaire->forceDelete();
            }
        }
        return $this->handleResponse(GestionnaireResource::collection($gestionnaires), 'tous gestionnaires supprimés définitivement');
    }
    public function restore( $id) {
        $gestionnaire = Gestionnaire::withTrashed()->where('id' ,  $id )->first();
        if (is_null($gestionnaire)) {
            return $this->handleError('gestionnaire n\'existe pas!');
        }elseif($gestionnaire->photo ==="default.jpeg" || $gestionnaire->photo === NULL){
            $gestionnaire->restore();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé!');
        } else{
            if(File::exists(('storage\trashImages\gestionnaire\\').$gestionnaire->photo)){
                File::copy(public_path('storage\trashImages\Gestionnaire\\').$gestionnaire->photo,
                public_path('storage\images\gestionnaire\\').$gestionnaire->photo);
                unlink(public_path('storage\trashImages\Gestionnaire\\').$gestionnaire->photo );
            }
            $gestionnaire->restore();
            return $this->handleResponse(new GestionnaireResource($gestionnaire), 'gestionnaire supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $gestionnaires= Gestionnaire::onlyTrashed()->get();
        foreach($gestionnaires as $gestionnaire){
            if($gestionnaire->photo ==="default.jpeg" || $gestionnaire->photo === NULL){
                $gestionnaire->restore();
            } else{
                if(File::exists(('storage\trashImages\gestionnaire\\').$gestionnaire->photo)){
                    File::copy(public_path('storage\trashImages\Gestionnaire\\').$gestionnaire->photo,
                    public_path('storage\images\gestionnaire\\').$gestionnaire->photo);
                    unlink(public_path('storage\trashImages\Gestionnaire\\').$gestionnaire->photo );
                }
                $gestionnaire->restore();
            }
        }
        return $this->handleResponse(GestionnaireResource::collection($gestionnaires), 'tous gestionnaires trashed');
    }
    public function listeSuppression(){
        $gestionnaire = Gestionnaire::onlyTrashed()->get();
        return $this->handleResponse(GestionnaireResource::collection($gestionnaire), 'affichage des gestionnaires');
    }

    public function exportInfoExcel(){
        return Excel::download(new GestionnaireExport  , 'gestionnaire-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new GestionnaireExport, 'gestionnaire-liste.csv');
    }
    public function pdf($id){
        $Gestionnaire = Gestionnaire::find($id);
        if (is_null($Gestionnaire)) {
            return $this->handleError('Gestionnaire n\'existe pas!');
        }else{
            $data= collect(Gestionnaire::getGestionnaireById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'nom' => $data[0]['nom'],
                'prenom' => $data[0]['prenom'],
                'CIN' => $data[0]['CIN'],
                'photo' => $data[0]['photo'],
                'adresse' => $data[0]['adresse'],
                'numero_telephone' => $data[0]['numero_telephone'],
                'email' => $data[0]['email'],
                'created_at' => $data[0]['created_at'],
                'updated_at' => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/Gestionnaire', $liste);
            return $pdf->download('gestionnaire.pdf');
        }
    }
    public function pdfAll(){
        $gestionnaire = Gestionnaire::all();
        if (is_null($gestionnaire)) {
            return $this->handleError('gestionnaire n\'existe pas!');
        }else{
            $p= GestionnaireResource::collection( $gestionnaire);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/gestionnaire', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('gestionnaire.pdf');
        }
    }
    public function pdfAllTrashed(){
        $gestionnaire = Gestionnaire::onlyTrashed()->get();
        if (is_null($gestionnaire)) {
            return $this->handleError('gestionnaire n\'existe pas!');
        }else{
            $p= GestionnaireResource::collection( $gestionnaire);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/gestionnaire', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('gestionnaire.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $gestionnaire = Gestionnaire::withTrashed()->where('id' ,  $id )->first();
        if (is_null($gestionnaire)) {
            return $this->handleError('Gestionnaire n\'existe pas!');
        }else{
                $data= collect(Gestionnaire::getGestionnaireByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    'nom' => $data[0]['nom'],
                    'prenom' => $data[0]['prenom'],
                    'CIN' => $data[0]['CIN'],
                    'photo' => $data[0]['photo'],
                    'adresse' => $data[0]['adresse'],
                    'numero_telephone' => $data[0]['numero_telephone'],
                    'email' => $data[0]['email'],
                    'created_at' => $data[0]['created_at'],
                    'updated_at' => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/Gestionnaire', $liste);
                return $pdf->download('gestionnaire.pdf');
            }
    }
}
