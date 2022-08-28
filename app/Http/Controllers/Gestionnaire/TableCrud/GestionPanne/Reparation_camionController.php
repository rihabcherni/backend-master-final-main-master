<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;

use App\Exports\GestionPanne\Reparation_camionExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Reparation_camion as Reparation_camionResource;
use App\Models\Reparation_camion;
use App\Http\Requests\GestionPanne\Reparation_camionRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class Reparation_camionController extends BaseController{
    public function index(){
        $reparation_camion = Reparation_camion::all();
        return $this->handleResponse(Reparation_camionResource::collection($reparation_camion), 'affichage des reparations camions!');
    }
    public function store(Reparation_camionRequest $request){
        $input = $request->all();
        $reparation_camion = Reparation_camion::create($input);
        return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion crée!');
    }
    public function show($id){
        $reparation_camion = Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError(' Reparation camion n\'existe pas!');
        }else{
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'Reparation camion existe.');
        }
    }
    public function update(Reparation_camionRequest $request, Reparation_camion $reparation_camion){
        $input = $request->all();
        $reparation_camion->update($input);
        return $this->handleResponse(new Reparation_camionResource($reparation_camion), ' Reparation camion modifié!');
    }
    public function destroy($id) {
        $reparation_camion = Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }elseif($reparation_camion->photo ==="default.jpeg" || $reparation_camion->photo === NULL){
            $reparation_camion->delete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé!');
        } else{
            if(File::exists(('storage\images\panneCamion\\').$reparation_camion->photo)){
                File::copy(public_path('storage\images\panneCamion\\').$reparation_camion->photo,
                public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo);
                unlink(public_path('storage\images\panneCamion\\').$reparation_camion->photo );
            }
            $reparation_camion->delete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé!');
        }
    }
    public function hdelete( $id) {
        $reparation_camion = Reparation_camion::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }elseif($reparation_camion->photo ==="default.jpeg" || $reparation_camion->photo === NULL){
            $reparation_camion->forceDelete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé!');
        } else{
            if(File::exists(('storage\trashImages\panneCamion\\').$reparation_camion->photo)){
                unlink(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo );
            }
            $reparation_camion->forceDelete();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $reparation_camions = Reparation_camion::onlyTrashed()->get();
        foreach($reparation_camions as $reparation_camion){
            if($reparation_camion->photo ==="default.jpeg" || $reparation_camion->photo === NULL){
                $reparation_camion->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\panneCamion\\').$reparation_camion->photo)){
                    unlink(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo );
                }
                $reparation_camion->forceDelete();
            }
        }
        return $this->handleResponse(Reparation_camionResource::collection($reparation_camions), 'tous reparations camions supprimés définitivement');
    }
    public function restore( $id) {
        $reparation_camion = Reparation_camion::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }elseif($reparation_camion->photo ==="default.jpeg" || $reparation_camion->photo === NULL){
            $reparation_camion->restore();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé!');
        } else{
            if(File::exists(('storage\trashImages\panneCamion\\').$reparation_camion->photo)){
                File::copy(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo,
                public_path('storage\images\panneCamion\\').$reparation_camion->photo);
                unlink(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo );
            }
            $reparation_camion->restore();
            return $this->handleResponse(new Reparation_camionResource($reparation_camion), 'reparation camion supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $reparation_camions= Reparation_camion::onlyTrashed()->get();
        foreach($reparation_camions as $reparation_camion){
            if($reparation_camion->photo ==="default.jpeg" || $reparation_camion->photo === NULL){
                $reparation_camion->restore();
            } else{
                if(File::exists(('storage\trashImages\panneCamion\\').$reparation_camion->photo)){
                    File::copy(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo,
                    public_path('storage\images\panneCamion\\').$reparation_camion->photo);
                    unlink(public_path('storage\trashImages\panneCamion\\').$reparation_camion->photo );
                }
                $reparation_camion->restore();
            }
        }
        return $this->handleResponse(Reparation_camionResource::collection($reparation_camions), 'tous reparations camions trashed');
    }
    public function listeSuppression(){
        $reparation_camion = Reparation_camion::onlyTrashed()->get();
        return $this->handleResponse(Reparation_camionResource::collection($reparation_camion), 'affichage des reparations camions');
    }
    public function exportInfoExcel(){
        return Excel::download(new Reparation_camionExport  , 'reparation-camion-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new Reparation_camionExport, 'reparation-camion-liste.csv');
    }
    public function pdf($id){
        $reparation_camion = Reparation_camion::find($id);
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }else{
            $data= collect(Reparation_camion::getReparationCamionById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "camion_id" => $data[0]['camion_id'],
                "matricule" => $data[0]['matricule'],
                "mecanicien_id" => $data[0]['mecanicien_id'],
                "mecanicien_CIN" => $data[0]['mecanicien_CIN'],
                "mecanicien_nom_prenom" => $data[0]['mecanicien_nom_prenom'],
                "image_panne_camion" => $data[0]['image_panne_camion'],
                "description_panne" => $data[0]['description_panne'],
                "camion" => $data[0]['camion'],
                "mecanicien" => $data[0]['mecanicien'],
                "cout" => $data[0]['cout'],
                "date_debut_reparation" => $data[0]['date_debut_reparation'],
                "date_fin_reparation" => $data[0]['date_fin_reparation'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPanne/reparationCamion', $liste);
            return $pdf->download('reparation-camion.pdf');
        }
    }
    public function pdfAll(){
        $reparation_camion = Reparation_camion::all();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }else{
            $p= Reparation_camionResource::collection( $reparation_camion);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPanne/reparationCamion', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('reparation-camion.pdf');
        }
    }
    public function pdfAllTrashed(){
        $reparation_camion = Reparation_camion::onlyTrashed()->get();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion n\'existe pas!');
        }else{
            $p= Reparation_camionResource::collection( $reparation_camion);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionPanne/reparationCamion', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('reparation-camion.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $reparation_camion = Reparation_camion::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparation_camion)) {
            return $this->handleError('reparation camion  n\'existe pas!');
        }else{
                $data= collect(Reparation_camion::getReparationCamionByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "camion_id" => $data[0]['camion_id'],
                    "matricule" => $data[0]['matricule'],
                    "mecanicien_id" => $data[0]['mecanicien_id'],
                    "mecanicien_CIN" => $data[0]['mecanicien_CIN'],
                    "mecanicien_nom_prenom" => $data[0]['mecanicien_nom_prenom'],
                    "image_panne_camion" => $data[0]['image_panne_camion'],
                    "description_panne" => $data[0]['description_panne'],
                    "camion" => $data[0]['camion'],
                    "mecanicien" => $data[0]['mecanicien'],
                    "cout" => $data[0]['cout'],
                    "date_debut_reparation" => $data[0]['date_debut_reparation'],
                    "date_fin_reparation" => $data[0]['date_fin_reparation'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionPanne/reparationCamion', $liste);
                return $pdf->download('reparation-camion.pdf');
            }
    }
}
