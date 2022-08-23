<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\OuvrierExport;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Ouvrier as OuvrierResource;
use App\Models\Ouvrier;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Requests\GestionCompte\OuvrierRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class OuvrierController extends BaseController{
    public function index(){
        $ouvrier = Ouvrier::all();
        return $this->handleResponse(OuvrierResource::collection($ouvrier), 'Affichage des Ouvriers!');
    }
    public function store(OuvrierRequest $request){
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $ouvrier = Ouvrier::create($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier crée!');
    }
    public function show($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier existe.');
        }
    }
    public function update(OuvrierRequest $request, Ouvrier $ouvrier){
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }

        $ouvrier->update($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier modifié!');
    }
    public function destroy($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }elseif($ouvrier->photo ==="default.jpeg" || $ouvrier->photo === NULL){
            $ouvrier->delete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'ouvrier supprimé!');
        } else{
            if(File::exists(('storage\images\ouvrier\\').$ouvrier->photo)){
                File::copy(public_path('storage\images\ouvrier\\').$ouvrier->photo,
                public_path('storage\trashImages\ouvrier\\').$ouvrier->photo);
                unlink(public_path('storage\images\ouvrier\\').$ouvrier->photo );
            }
            $ouvrier->delete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier supprimé!');
        }
    }
    
    public function hdelete( $id) {
        $ouvrier = Ouvrier::withTrashed()->where('id' ,  $id )->first();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }elseif($ouvrier->photo ==="default.jpeg" || $ouvrier->photo === NULL){
            $ouvrier->forceDelete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'ouvrier supprimé!');
        } else{
            if(File::exists(('storage\trashImages\ouvrier\\').$ouvrier->photo)){
                unlink(public_path('storage\trashImages\ouvrier\\').$ouvrier->photo );
            }
            $ouvrier->forceDelete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'ouvrier supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $ouvriers = Ouvrier::onlyTrashed()->get();
        foreach($ouvriers as $ouvrier){
            if($ouvrier->photo ==="default.jpeg" || $ouvrier->photo === NULL){
                $ouvrier->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\ouvrier\\').$ouvrier->photo)){
                    unlink(public_path('storage\trashImages\ouvrier\\').$ouvrier->photo );
                }
                $ouvrier->forceDelete();
            }
        }
        return $this->handleResponse(OuvrierResource::collection($ouvriers), 'tous ouvriers supprimés définitivement');
    }
    public function restore( $id) {
        $ouvrier = Ouvrier::withTrashed()->where('id' ,  $id )->first();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }elseif($ouvrier->photo ==="default.jpeg" || $ouvrier->photo === NULL){
            $ouvrier->restore();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'ouvrier supprimé!');
        } else{
            if(File::exists(('storage\trashImages\ouvrier\\').$ouvrier->photo)){
                File::copy(public_path('storage\trashImages\Ouvrier\\').$ouvrier->photo,
                public_path('storage\images\ouvrier\\').$ouvrier->photo);
                unlink(public_path('storage\trashImages\Ouvrier\\').$ouvrier->photo );
            }
            $ouvrier->restore();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'ouvrier supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $ouvriers= Ouvrier::onlyTrashed()->get();
        foreach($ouvriers as $ouvrier){
            if($ouvrier->photo ==="default.jpeg" || $ouvrier->photo === NULL){
                $ouvrier->restore();
            } else{
                if(File::exists(('storage\trashImages\ouvrier\\').$ouvrier->photo)){
                    File::copy(public_path('storage\trashImages\Ouvrier\\').$ouvrier->photo,
                    public_path('storage\images\ouvrier\\').$ouvrier->photo);
                    unlink(public_path('storage\trashImages\Ouvrier\\').$ouvrier->photo );
                }
                $ouvrier->restore();
            }
        }
        return $this->handleResponse(OuvrierResource::collection($ouvriers), 'tous ouvriers trashed');
    }
    public function listeSuppression(){
        $ouvrier = Ouvrier::onlyTrashed()->get();
        return $this->handleResponse(OuvrierResource::collection($ouvrier), 'affichage des ouvriers');
    }

    public function exportInfoExcel(){
        return Excel::download(new OuvrierExport  , 'ouvrier-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new OuvrierExport, 'ouvrier-liste.csv');
    }
    public function pdf($id){
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            $data= collect(Ouvrier::getOuvrierById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'camion_id' => $data[0]['camion_id'],
                'matricule' => $data[0]['matricule'],
                'poste' => $data[0]['poste'],
                'nom' => $data[0]['nom'],
                'prenom' => $data[0]['prenom'],
                'adresse' => $data[0]['adresse'],
                'CIN' => $data[0]['CIN'],
                'photo' => $data[0]['photo'],
                'numero_telephone' => $data[0]['numero_telephone'],
                'email' => $data[0]['email'],
                'created_at' => $data[0]['created_at'],
                'updated_at' => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/ouvrier', $liste);
            return $pdf->download('ouvrier.pdf');
        }
    }
    public function pdfAll(){
        $ouvrier = Ouvrier::all();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            $p= OuvrierResource::collection( $ouvrier);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/ouvrier', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('ouvrier.pdf');
        }
    }

    public function pdfAllTrashed(){
        $ouvrier = Ouvrier::onlyTrashed()->get();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            $p= OuvrierResource::collection( $ouvrier);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/ouvrier', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('ouvrier.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $ouvrier = Ouvrier::withTrashed()->where('id' ,  $id )->first();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
                $data= collect(Ouvrier::getOuvrierByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    'camion_id' => $data[0]['camion_id'],
                    'matricule' => $data[0]['matricule'],
                    'poste' => $data[0]['poste'],
                    'nom' => $data[0]['nom'],
                    'prenom' => $data[0]['prenom'],
                    'adresse' => $data[0]['adresse'],
                    'CIN' => $data[0]['CIN'],
                    'photo' => $data[0]['photo'],
                    'numero_telephone' => $data[0]['numero_telephone'],
                    'email' => $data[0]['email'],
                    'created_at' => $data[0]['created_at'],
                    'updated_at' => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/ouvrier', $liste);
                return $pdf->download('ouvrier.pdf');
            }
    }
}

