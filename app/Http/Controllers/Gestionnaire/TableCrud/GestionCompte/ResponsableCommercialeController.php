<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\Responsable_commercialExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_commercial as Responsable_commercialResource;
use App\Models\Responsable_commercial;
use App\Http\Requests\GestionCompte\ResponsableCommercialeRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

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
        }elseif($responsablecommercial->photo ==="default.jpeg" || $responsablecommercial->photo === NULL){
            $responsablecommercial->delete();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial supprimé!');
        } else{
            if(File::exists(('storage\images\responsable_commercial\\').$responsablecommercial->photo)){
                File::copy(public_path('storage\images\responsable_commercial\\').$responsablecommercial->photo,
                public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo);
                unlink(public_path('storage\images\responsable_commercial\\').$responsablecommercial->photo );
            }
            $responsablecommercial->delete();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial supprimé!');
        }
    }

    public function hdelete( $id) {
        $responsablecommercial = Responsable_commercial::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial n\'existe pas!');
        }elseif($responsablecommercial->photo ==="default.jpeg" || $responsablecommercial->photo === NULL){
            $responsablecommercial->forceDelete();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial  supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo)){
                unlink(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo );
            }
            $responsablecommercial->forceDelete();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial  supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $responsablecommercials = Responsable_commercial::onlyTrashed()->get();
        foreach($responsablecommercials as $responsablecommercial){
            if($responsablecommercial->photo ==="default.jpeg" || $responsablecommercial->photo === NULL){
                $responsablecommercial->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo)){
                    unlink(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo );
                }
                $responsablecommercial->forceDelete();
            }
        }
        return $this->handleResponse(Responsable_commercialResource::collection($responsablecommercials), 'tous responsables commercial supprimés définitivement');
    }
    public function restore( $id) {
        $responsablecommercial = Responsable_commercial::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial  n\'existe pas!');
        }elseif($responsablecommercial->photo ==="default.jpeg" || $responsablecommercial->photo === NULL){
            $responsablecommercial->restore();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo)){
                File::copy(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo,
                public_path('storage\images\responsable_commercial\\').$responsablecommercial->photo);
                unlink(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo );
            }
            $responsablecommercial->restore();
            return $this->handleResponse(new Responsable_commercialResource($responsablecommercial), 'responsable commercial supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $responsablecommercials= Responsable_commercial::onlyTrashed()->get();
        foreach($responsablecommercials as $responsablecommercial){
            if($responsablecommercial->photo ==="default.jpeg" || $responsablecommercial->photo === NULL){
                $responsablecommercial->restore();
            } else{
                if(File::exists(('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo)){
                    File::copy(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo,
                    public_path('storage\images\responsable_commercial\\').$responsablecommercial->photo);
                    unlink(public_path('storage\trashImages\responsable_commercial\\').$responsablecommercial->photo );
                }
                $responsablecommercial->restore();
            }
        }
        return $this->handleResponse(Responsable_commercialResource::collection($responsablecommercials), 'tous responsable_commercials trashed');
    }
    public function listeSuppression(){
        $responsablecommercial = Responsable_commercial::onlyTrashed()->get();
        return $this->handleResponse(Responsable_commercialResource::collection($responsablecommercial), 'affichage des responsable_commercials');
    }
    public function exportInfoExcel(){
        return Excel::download(new Responsable_commercialExport  , 'responsable-commerciale-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Responsable_commercialExport, 'responsable-commerciale-liste.csv');
    }
    public function pdf($id){
        $responsable_commerciale = Responsable_commercial::find($id);
        if (is_null($responsable_commerciale)) {
            return $this->handleError('responsable commerciale n\'existe pas!');
        }else{
            $data= collect(Responsable_commercial::getResponsableCommercialeById($id))->toArray();
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
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/responsableCommerciale', $liste);
            return $pdf->download('responsable-commerciale.pdf');
        }
    }
    public function pdfAll(){
        $responsable_commerciale = Responsable_commercial::all();
        if (is_null($responsable_commerciale)) {
            return $this->handleError('responsable commerciale n\'existe pas!');
        }else{
            $p= Responsable_commercialResource::collection( $responsable_commerciale);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/responsableCommerciale', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('responsable-commerciale.pdf');
        }
    }

    public function pdfAllTrashed(){
        $responsablecommercial = Responsable_commercial::onlyTrashed()->get();
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial n\'existe pas!');
        }else{
            $p= Responsable_commercialResource::collection( $responsablecommercial);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/responsableCommerciale', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('responsable-commercial.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $responsablecommercial = Responsable_commercial::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablecommercial)) {
            return $this->handleError('responsable commercial n\'existe pas!');
        }else{
                $data= collect(Responsable_commercial::getResponsableCommercialeByIdTrashed($id))->toArray();
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
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/responsableCommerciale', $liste);
                return $pdf->download('responsable-commercial.pdf');
            }
    }
}
