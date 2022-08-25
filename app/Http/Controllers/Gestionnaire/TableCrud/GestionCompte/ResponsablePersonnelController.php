<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\Responsable_personnelExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_personnel as Responsable_personnelResource;
use App\Http\Requests\GestionCompte\ResponsablePersonnelRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Authentification\SendFirstPasswordController;
use App\Models\Responsable_personnel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class ResponsablePersonnelController extends BaseController{
    public function index(){
        $responsablePersonnel = Responsable_personnel::all();
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnel), 'Affichage des responsable personnel!');
    }
    public function store(ResponsablePersonnelRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new SendFirstPasswordController;
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
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel crée!');
    }
    public function show($id){
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel existe.');
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
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel modifié!');
    }
    public function destroy($id) {
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel n\'existe pas!');
        }elseif($responsablePersonnel->photo ==="default.jpeg" || $responsablePersonnel->photo === NULL){
            $responsablePersonnel->delete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel supprimé!');
        } else{
            if(File::exists(('storage\images\responsable_personnel\\').$responsablePersonnel->photo)){
                File::copy(public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo,
                public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo);
                unlink(public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo );
            }
            $responsablePersonnel->delete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel supprimé!');
        }
    }

    public function hdelete( $id) {
        $responsablePersonnel = Responsable_personnel::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel n\'existe pas!');
        }elseif($responsablePersonnel->photo ==="default.jpeg" || $responsablePersonnel->photo === NULL){
            $responsablePersonnel->forceDelete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel  supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo)){
                unlink(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo );
            }
            $responsablePersonnel->forceDelete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel  supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $responsablePersonnels = Responsable_personnel::onlyTrashed()->get();
        foreach($responsablePersonnels as $responsablePersonnel){
            if($responsablePersonnel->photo ==="default.jpeg" || $responsablePersonnel->photo === NULL){
                $responsablePersonnel->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo)){
                    unlink(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo );
                }
                $responsablePersonnel->forceDelete();
            }
        }
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnels), 'tous responsables personnel supprimés définitivement');
    }
    public function restore( $id) {
        $responsablePersonnel = Responsable_personnel::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel  n\'existe pas!');
        }elseif($responsablePersonnel->photo ==="default.jpeg" || $responsablePersonnel->photo === NULL){
            $responsablePersonnel->restore();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel supprimé!');
        } else{
            if(File::exists(('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo)){
                File::copy(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo,
                public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo);
                unlink(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo );
            }
            $responsablePersonnel->restore();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable personnel supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $responsablePersonnels= Responsable_personnel::onlyTrashed()->get();
        foreach($responsablePersonnels as $responsablePersonnel){
            if($responsablePersonnel->photo ==="default.jpeg" || $responsablePersonnel->photo === NULL){
                $responsablePersonnel->restore();
            } else{
                if(File::exists(('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo)){
                    File::copy(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo,
                    public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo);
                    unlink(public_path('storage\trashImages\responsable_personnel\\').$responsablePersonnel->photo );
                }
                $responsablePersonnel->restore();
            }
        }
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnels), 'tous responsable personnel trashed');
    }
    public function listeSuppression(){
        $responsablePersonnel = Responsable_personnel::onlyTrashed()->get();
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnel), 'affichage des responsable personnel');
    }

    public function exportInfoExcel(){
        return Excel::download(new Responsable_personnelExport  , 'responsable-personnele-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Responsable_personnelExport, 'responsable-personnele-liste.csv');
    }
    public function pdf($id){
        $responsable_personnele = Responsable_personnel::find($id);
        if (is_null($responsable_personnele)) {
            return $this->handleError('responsable personnele n\'existe pas!');
        }else{
            $data= collect(Responsable_personnel::getResponsablePersonnelById($id))->toArray();
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
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/responsablePersonnel', $liste);
            return $pdf->download('responsable-personnele.pdf');
        }
    }
    public function pdfAll(){
        $responsable_personnele = Responsable_personnel::all();
        if (is_null($responsable_personnele)) {
            return $this->handleError('responsable personnele n\'existe pas!');
        }else{
            $p= Responsable_personnelResource::collection( $responsable_personnele);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/responsablePersonnel', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('responsable-personnele.pdf');
        }
    }
    public function pdfAllTrashed(){
        $responsablePersonnel = Responsable_personnel::onlyTrashed()->get();
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel n\'existe pas!');
        }else{
            $p= Responsable_personnelResource::collection( $responsablePersonnel);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/responsablePersonnel', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('responsable-personnel.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $responsablePersonnel = Responsable_personnel::withTrashed()->where('id' ,  $id )->first();
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable personnel n\'existe pas!');
        }else{
                $data= collect(Responsable_personnel::getResponsablePersonnelByIdTrashed($id))->toArray();
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
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/responsablePersonnel', $liste);
                return $pdf->download('responsable-personnel.pdf');
            }
    }
}
