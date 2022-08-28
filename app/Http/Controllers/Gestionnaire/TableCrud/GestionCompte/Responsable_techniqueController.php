<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\Responsable_techniqueExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_technique as Responsable_techniqueResource;
use App\Http\Requests\GestionCompte\Responsable_techniqueRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Authentification\SendFirstPasswordController;
use App\Models\Responsable_technique;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class Responsable_techniqueController extends BaseController{
    public function index(){
        $Responsable_technique = Responsable_technique::all();
        return $this->handleResponse(Responsable_techniqueResource::collection($Responsable_technique), 'Affichage des responsable technique!');
    }
    public function store(Responsable_techniqueRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new SendFirstPasswordController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/responsable_technique';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $Responsable_technique= Responsable_technique::create($input);
        return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique crée!');
    }
    public function show($id){
        $Responsable_technique = Responsable_technique::find($id);
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique existe.');
        }
    }
    public function update(Responsable_techniqueRequest $request, Responsable_technique $Responsable_technique) {
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'responsable_technique/';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }
        $Responsable_technique->update($input);
        return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique modifié!');
    }
    public function destroy($id) {
        $Responsable_technique = Responsable_technique::find($id);
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }elseif($Responsable_technique->photo ==="default.jpeg" || $Responsable_technique->photo === NULL){
            $Responsable_technique->delete();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique supprimé!');
        } else{
            if(File::exists(('storage\images\responsable_technique\\').$Responsable_technique->photo)){
                File::copy(public_path('storage\images\responsable_technique\\').$Responsable_technique->photo,
                public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo);
                unlink(public_path('storage\images\responsable_technique\\').$Responsable_technique->photo );
            }
            $Responsable_technique->delete();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique supprimé!');
        }
    }

    public function hdelete( $id) {
        $Responsable_technique = Responsable_technique::withTrashed()->where('id' ,  $id )->first();
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }elseif($Responsable_technique->photo ==="default.jpeg" || $Responsable_technique->photo === NULL){
            $Responsable_technique->forceDelete();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique  supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_technique\\').$Responsable_technique->photo)){
                unlink(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo );
            }
            $Responsable_technique->forceDelete();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique  supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $Responsable_techniques = Responsable_technique::onlyTrashed()->get();
        foreach($Responsable_techniques as $Responsable_technique){
            if($Responsable_technique->photo ==="default.jpeg" || $Responsable_technique->photo === NULL){
                $Responsable_technique->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\responsable_technique\\').$Responsable_technique->photo)){
                    unlink(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo );
                }
                $Responsable_technique->forceDelete();
            }
        }
        return $this->handleResponse(Responsable_techniqueResource::collection($Responsable_techniques), 'tous responsables technique supprimés définitivement');
    }
    public function restore( $id) {
        $Responsable_technique = Responsable_technique::withTrashed()->where('id' ,  $id )->first();
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique  n\'existe pas!');
        }elseif($Responsable_technique->photo ==="default.jpeg" || $Responsable_technique->photo === NULL){
            $Responsable_technique->restore();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_technique\\').$Responsable_technique->photo)){
                File::copy(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo,
                public_path('storage\images\responsable_technique\\').$Responsable_technique->photo);
                unlink(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo );
            }
            $Responsable_technique->restore();
            return $this->handleResponse(new Responsable_techniqueResource($Responsable_technique), 'responsable technique supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $Responsable_techniques= Responsable_technique::onlyTrashed()->get();
        foreach($Responsable_techniques as $Responsable_technique){
            if($Responsable_technique->photo ==="default.jpeg" || $Responsable_technique->photo === NULL){
                $Responsable_technique->restore();
            } else{
                if(File::exists(('storage\trashImages\responsable_technique\\').$Responsable_technique->photo)){
                    File::copy(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo,
                    public_path('storage\images\responsable_technique\\').$Responsable_technique->photo);
                    unlink(public_path('storage\trashImages\responsable_technique\\').$Responsable_technique->photo );
                }
                $Responsable_technique->restore();
            }
        }
        return $this->handleResponse(Responsable_techniqueResource::collection($Responsable_techniques), 'tous responsable technique trashed');
    }
    public function listeSuppression(){
        $Responsable_technique = Responsable_technique::onlyTrashed()->get();
        return $this->handleResponse(Responsable_techniqueResource::collection($Responsable_technique), 'affichage des responsable technique');
    }
    public function exportInfoExcel(){
        return Excel::download(new Responsable_techniqueExport  , 'responsable-technique-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Responsable_techniqueExport, 'responsable-technique-liste.csv');
    }
    public function pdf($id){
        $ResponsableTechnique = Responsable_technique::find($id);
        if (is_null($ResponsableTechnique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }else{
            $data= collect(Responsable_technique::getResponsableTechniqueById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'nom' => $data[0]['nom'],
                'prenom' => $data[0]['prenom'],
                'CIN' => $data[0]['CIN'],
                'photo' => $data[0]['photo'],
                'numero_telephone' => $data[0]['numero_telephone'],
                'email' => $data[0]['email'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/responsableTechnique', $liste);
            return $pdf->download('responsable-technique.pdf');
        }
    }
    public function pdfAll(){
        $ResponsableTechnique = Responsable_technique::all();
        if (is_null($ResponsableTechnique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }else{
            $p= Responsable_techniqueResource::collection( $ResponsableTechnique);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/responsableTechnique', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('responsable-technique.pdf');
        }
    }
    public function pdfAllTrashed(){
        $Responsable_technique = Responsable_technique::onlyTrashed()->get();
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }else{
            $p= Responsable_techniqueResource::collection( $Responsable_technique);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/responsableTechnique', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('responsable-technique.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $Responsable_technique = Responsable_technique::withTrashed()->where('id' ,  $id )->first();
        if (is_null($Responsable_technique)) {
            return $this->handleError('responsable technique n\'existe pas!');
        }else{
                $data= collect(Responsable_technique::getResponsableTechniqueByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    'nom' => $data[0]['nom'],
                    'prenom' => $data[0]['prenom'],
                    'CIN' => $data[0]['CIN'],
                    'photo' => $data[0]['photo'],
                    'numero_telephone' => $data[0]['numero_telephone'],
                    'email' => $data[0]['email'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/responsableTechnique', $liste);
                return $pdf->download('responsable-technique.pdf');
            }
    }
}
