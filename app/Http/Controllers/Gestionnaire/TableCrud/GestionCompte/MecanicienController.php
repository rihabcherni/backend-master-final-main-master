<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\MecanicienExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Mecanicien as MecanicienResource;
use App\Models\Mecanicien;
use App\Http\Requests\GestionCompte\MecanicienRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class MecanicienController extends BaseController{
    public function index(){
        $mecanicien = Mecanicien::all();
        return $this->handleResponse(MecanicienResource::collection($mecanicien), 'affichage de tous les mecaniciens');
    }
    public function store(MecanicienRequest $request){
        $input = $request->all();
        $mecanicien = Mecanicien::create($input);
        return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien crée!');
    }
    public function show($id){
        $mecanicien = Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('Mecanicien n\'existe pas!');
        }else{
            return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien existe.');
        }
    }
    public function update(MecanicienRequest $request, Mecanicien $mecanicien){
        $input = $request->all();
        $mecanicien->update($input);
        return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien modifié!');
    }

    public function destroy($id) {
        $mecanicien = Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }elseif($mecanicien->photo ==="default.jpeg" || $mecanicien->photo === NULL){
            $mecanicien->delete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé!');
        } else{
            if(File::exists(('storage\images\mecanicien\\').$mecanicien->photo)){
                File::copy(public_path('storage\images\mecanicien\\').$mecanicien->photo,
                public_path('storage\trashImages\mecanicien\\').$mecanicien->photo);
                unlink(public_path('storage\images\mecanicien\\').$mecanicien->photo );
            }
            $mecanicien->delete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé!');
        }
    }
    public function hdelete( $id) {
        $mecanicien = Mecanicien::withTrashed()->where('id' ,  $id )->first();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }elseif($mecanicien->photo ==="default.jpeg" || $mecanicien->photo === NULL){
            $mecanicien->forceDelete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé!');
        } else{
            if(File::exists(('storage\trashImages\mecanicien\\').$mecanicien->photo)){
                unlink(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo );
            }
            $mecanicien->forceDelete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $mecaniciens = Mecanicien::onlyTrashed()->get();
        foreach($mecaniciens as $mecanicien){
            if($mecanicien->photo ==="default.jpeg" || $mecanicien->photo === NULL){
                $mecanicien->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\mecanicien\\').$mecanicien->photo)){
                    unlink(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo );
                }
                $mecanicien->forceDelete();
            }
        }
        return $this->handleResponse(MecanicienResource::collection($mecaniciens), 'tous mecaniciens supprimés définitivement');
    }
    public function restore( $id) {
        $mecanicien = Mecanicien::withTrashed()->where('id' ,  $id )->first();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }elseif($mecanicien->photo ==="default.jpeg" || $mecanicien->photo === NULL){
            $mecanicien->restore();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé!');
        } else{
            if(File::exists(('storage\trashImages\mecanicien\\').$mecanicien->photo)){
                File::copy(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo,
                public_path('storage\images\mecanicien\\').$mecanicien->photo);
                unlink(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo );
            }
            $mecanicien->restore();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'mecanicien supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $mecaniciens= Mecanicien::onlyTrashed()->get();
        foreach($mecaniciens as $mecanicien){
            if($mecanicien->photo ==="default.jpeg" || $mecanicien->photo === NULL){
                $mecanicien->restore();
            } else{
                if(File::exists(('storage\trashImages\mecanicien\\').$mecanicien->photo)){
                    File::copy(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo,
                    public_path('storage\images\mecanicien\\').$mecanicien->photo);
                    unlink(public_path('storage\trashImages\mecanicien\\').$mecanicien->photo );
                }
                $mecanicien->restore();
            }
        }
        return $this->handleResponse(MecanicienResource::collection($mecaniciens), 'tous mecaniciens trashed');
    }
    public function listeSuppression(){
        $mecanicien = Mecanicien::onlyTrashed()->get();
        return $this->handleResponse(MecanicienResource::collection($mecanicien), 'affichage des mecaniciens');
    }

    public function exportInfoExcel(){
        return Excel::download(new MecanicienExport  , 'mecanicien-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new MecanicienExport, 'mecanicien-liste.csv');
    }
    public function pdf($id){
        $mecanicien = Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }else{
            $data= collect(Mecanicien::getMecanicienById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom" => $data[0]['nom'],
                "prenom" => $data[0]['prenom'],
                "CIN" => $data[0]['CIN'],
                "photo" => $data[0]['photo'],
                "numero_telephone" => $data[0]['numero_telephone'],
                "email" => $data[0]['email'],
                "adresse" => $data[0]['adresse'],
                "Liste_camions_repares"=> $data[0]['Liste_camions_repares'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/mecanicien', $liste);
            return $pdf->download('mecanicien.pdf');
        }
    }
    public function pdfAll(){
        $mecanicien = Mecanicien::all();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }else{
            $p= MecanicienResource::collection( $mecanicien);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/mecanicien', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('mecanicien.pdf');
        }
    }
    public function pdfAllTrashed(){
        $mecanicien = Mecanicien::onlyTrashed()->get();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }else{
            $p= MecanicienResource::collection( $mecanicien);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/mecanicien', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('mecanicien.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $mecanicien = Mecanicien::withTrashed()->where('id' ,  $id )->first();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }else{
                $data= collect(Mecanicien::getMecanicienByIdTrashed($id))->toArray();
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
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/mecanicien', $liste);
                return $pdf->download('mecanicien.pdf');
            }
    }
}
