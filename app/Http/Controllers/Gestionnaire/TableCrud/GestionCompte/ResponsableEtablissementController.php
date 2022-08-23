<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\Responsable_etablissementExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_etablissement as Responsable_etablissementResource;
use App\Models\Responsable_etablissement;
use App\Http\Requests\GestionCompte\ResponsableEtablissementRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

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
            return $this->handleError('responsable etablissement n\'existe pas!');
        }elseif($responsableEtablissement->photo ==="default.jpeg" || $responsableEtablissement->photo === NULL){
            $responsableEtablissement->delete();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement supprimé!');
        } else{
            if(File::exists(('storage\images\responsable_etablissement\\').$responsableEtablissement->photo)){
                File::copy(public_path('storage\images\responsable_etablissement\\').$responsableEtablissement->photo,
                public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo);
                unlink(public_path('storage\images\responsable_etablissement\\').$responsableEtablissement->photo );
            }
            $responsableEtablissement->delete();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement supprimé!');
        }
    }

    public function hdelete( $id) {
        $responsableEtablissement = Responsable_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable etablissement n\'existe pas!');
        }elseif($responsableEtablissement->photo ==="default.jpeg" || $responsableEtablissement->photo === NULL){
            $responsableEtablissement->forceDelete();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement  supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo)){
                unlink(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo );
            }
            $responsableEtablissement->forceDelete();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement  supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $responsableEtablissements = Responsable_etablissement::onlyTrashed()->get();
        foreach($responsableEtablissements as $responsableEtablissement){
            if($responsableEtablissement->photo ==="default.jpeg" || $responsableEtablissement->photo === NULL){
                $responsableEtablissement->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo)){
                    unlink(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo );
                }
                $responsableEtablissement->forceDelete();
            }
        }
        return $this->handleResponse(Responsable_etablissementResource::collection($responsableEtablissements), 'tous responsables etablissement supprimés définitivement');
    }
    public function restore( $id) {
        $responsableEtablissement = Responsable_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable etablissement  n\'existe pas!');
        }elseif($responsableEtablissement->photo ==="default.jpeg" || $responsableEtablissement->photo === NULL){
            $responsableEtablissement->restore();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo)){
                File::copy(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo,
                public_path('storage\images\responsable_etablissement\\').$responsableEtablissement->photo);
                unlink(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo );
            }
            $responsableEtablissement->restore();
            return $this->handleResponse(new Responsable_etablissementResource($responsableEtablissement), 'responsable etablissement supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $responsableEtablissements= Responsable_etablissement::onlyTrashed()->get();
        foreach($responsableEtablissements as $responsableEtablissement){
            if($responsableEtablissement->photo ==="default.jpeg" || $responsableEtablissement->photo === NULL){
                $responsableEtablissement->restore();
            } else{
                if(File::exists(('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo)){
                    File::copy(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo,
                    public_path('storage\images\responsable_etablissement\\').$responsableEtablissement->photo);
                    unlink(public_path('storage\trashImages\responsable_etablissement\\').$responsableEtablissement->photo );
                }
                $responsableEtablissement->restore();
            }
        }
        return $this->handleResponse(Responsable_etablissementResource::collection($responsableEtablissements), 'tous responsable etablissement trashed');
    }
    public function listeSuppression(){
        $responsableEtablissement = Responsable_etablissement::onlyTrashed()->get();
        return $this->handleResponse(Responsable_etablissementResource::collection($responsableEtablissement), 'affichage des responsable etablissement');
    }
    public function exportInfoExcel(){
        return Excel::download(new Responsable_etablissementExport  , 'responsable-etablissement-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Responsable_etablissementExport, 'responsable-etablissement-liste.csv');
    }
    public function pdf($id){
        $responsable_etablissement = Responsable_etablissement::find($id);
        if (is_null($responsable_etablissement)) {
            return $this->handleError('Responsable etablissement n\'existe pas!');
        }else{
            $data= collect(Responsable_etablissement::getResponsableEtablissementById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "etablissement_id"=> $data[0]['etablissement_id'],
                "etablissement"=> $data[0]['etablissement'],
                "nom"=> $data[0]['nom'],
                "prenom"=> $data[0]['prenom'],
                "photo"=> $data[0]['photo'],
                "numero_fixe"=> $data[0]['numero_fixe'],
                "adresse"=> $data[0]['adresse'],
                "numero_telephone"=> $data[0]['numero_telephone'],
                "email"=> $data[0]['email'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/responsableEtablissement', $liste);
            return $pdf->download('responsable-etablissement.pdf');
        }
    }
    public function pdfAll(){
        $responsable_etablissement = Responsable_etablissement::all();
        if (is_null($responsable_etablissement)) {
            return $this->handleError('responsable-etablissement n\'existe pas!');
        }else{
            $p= Responsable_etablissementResource::collection( $responsable_etablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/responsableEtablissement', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('responsable-etablissement.pdf');
        }
    }
    public function pdfAllTrashed(){
        $responsableEtablissement = Responsable_etablissement::onlyTrashed()->get();
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable etablissement n\'existe pas!');
        }else{
            $p= Responsable_etablissementResource::collection( $responsableEtablissement);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/responsableEtablissement', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('responsable-etablissement.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $responsableEtablissement = Responsable_etablissement::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsableEtablissement)) {
            return $this->handleError('responsable etablissement n\'existe pas!');
        }else{
                $data= collect(Responsable_etablissement::getResponsableEtablissementByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "etablissement_id"=> $data[0]['etablissement_id'],
                    "etablissement"=> $data[0]['etablissement'],
                    "nom"=> $data[0]['nom'],
                    "prenom"=> $data[0]['prenom'],
                    "photo"=> $data[0]['photo'],
                    "numero_fixe"=> $data[0]['numero_fixe'],
                    "adresse"=> $data[0]['adresse'],
                    "numero_telephone"=> $data[0]['numero_telephone'],
                    "email"=> $data[0]['email'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/responsableEtablissement', $liste);
                return $pdf->download('responsable-etablissement.pdf');
            }
    }
}

