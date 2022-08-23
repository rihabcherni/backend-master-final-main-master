<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;

use App\Exports\ProductionPoubelle\FournisseurExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\Fournisseur as FournisseurResource;
use App\Models\Fournisseur;
use App\Http\Requests\ProductionPoubelle\FournisseurRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class FournisseurController extends BaseController{
    public function index(){
        $fournisseur = Fournisseur::all();
        return $this->handleResponse(FournisseurResource::collection($fournisseur), 'Affichage des fournisseurs');
    }
    public function store(FournisseurRequest $request){
        $input = $request->all();
        $fournisseur = Fournisseur::create($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur crée!');
    }
    public function show($id){
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur existe.');
        }
    }
    public function update(FournisseurRequest $request, Fournisseur $fournisseur){
        $input = $request->all();
        $fournisseur->update($input);
        return $this->handleResponse(new FournisseurResource($fournisseur), ' fournisseur modifié!');
    }
    public function destroy($id) {
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }elseif($fournisseur->photo ==="default.jpeg" || $fournisseur->photo === NULL){
            $fournisseur->delete();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé!');
        } else{
            if(File::exists(('storage\images\fournisseur\\').$fournisseur->photo)){
                File::copy(public_path('storage\images\fournisseur\\').$fournisseur->photo,
                public_path('storage\trashImages\fournisseur\\').$fournisseur->photo);
                unlink(public_path('storage\images\fournisseur\\').$fournisseur->photo );
            }
            $fournisseur->delete();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé!');
        }
    }
    public function hdelete( $id) {
        $fournisseur = Fournisseur::withTrashed()->where('id' ,  $id )->first();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }elseif($fournisseur->photo ==="default.jpeg" || $fournisseur->photo === NULL){
            $fournisseur->forceDelete();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé!');
        } else{
            if(File::exists(('storage\trashImages\fournisseur\\').$fournisseur->photo)){
                unlink(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo );
            }
            $fournisseur->forceDelete();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $fournisseurs = Fournisseur::onlyTrashed()->get();
        foreach($fournisseurs as $fournisseur){
            if($fournisseur->photo ==="default.jpeg" || $fournisseur->photo === NULL){
                $fournisseur->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\fournisseur\\').$fournisseur->photo)){
                    unlink(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo );
                }
                $fournisseur->forceDelete();
            }
        }
        return $this->handleResponse(FournisseurResource::collection($fournisseurs), 'tous fournisseurs supprimés définitivement');
    }
    public function restore( $id) {
        $fournisseur = Fournisseur::withTrashed()->where('id' ,  $id )->first();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }elseif($fournisseur->photo ==="default.jpeg" || $fournisseur->photo === NULL){
            $fournisseur->restore();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé!');
        } else{
            if(File::exists(('storage\trashImages\fournisseur\\').$fournisseur->photo)){
                File::copy(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo,
                public_path('storage\images\fournisseur\\').$fournisseur->photo);
                unlink(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo );
            }
            $fournisseur->restore();
            return $this->handleResponse(new FournisseurResource($fournisseur), 'fournisseur supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $fournisseurs= Fournisseur::onlyTrashed()->get();
        foreach($fournisseurs as $fournisseur){
            if($fournisseur->photo ==="default.jpeg" || $fournisseur->photo === NULL){
                $fournisseur->restore();
            } else{
                if(File::exists(('storage\trashImages\fournisseur\\').$fournisseur->photo)){
                    File::copy(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo,
                    public_path('storage\images\fournisseur\\').$fournisseur->photo);
                    unlink(public_path('storage\trashImages\fournisseur\\').$fournisseur->photo );
                }
                $fournisseur->restore();
            }
        }
        return $this->handleResponse(FournisseurResource::collection($fournisseurs), 'tous fournisseurs trashed');
    }
    public function listeSuppression(){
        $fournisseur = Fournisseur::onlyTrashed()->get();
        return $this->handleResponse(FournisseurResource::collection($fournisseur), 'affichage des fournisseurs');
    }
    public function exportInfoExcel(){
        return Excel::download(new FournisseurExport  , 'fournisseur-liste.xlsx');
    }
    public function exportInfoCSV(){
        return Excel::download(new FournisseurExport, 'fournisseur-liste.csv');
    }
    public function pdf($id){
        $fournisseur = Fournisseur::find($id);
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            $data= collect(Fournisseur::getFournisseurById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom"=> $data[0]['nom'],
                "prenom"=> $data[0]['prenom'],
                "CIN"=> $data[0]['CIN'],
                "photo"=> $data[0]['photo'],
                "numero_telephone"=> $data[0]['numero_telephone'],
                "email"=> $data[0]['email'],
                "adresse"=> $data[0]['adresse'],
                "Liste_matieres"=> $data[0]['Liste_matieres'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/ProductionPoubelle/fournisseur', $liste);
            return $pdf->download('fournisseur.pdf');
        }
    }
    public function pdfAll(){
        $fournisseur = Fournisseur::all();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            $p= FournisseurResource::collection( $fournisseur);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/ProductionPoubelle/fournisseur', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('fournisseur.pdf');
        }
    }
    public function pdfAllTrashed(){
        $fournisseur = Fournisseur::onlyTrashed()->get();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
            $p= FournisseurResource::collection( $fournisseur);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/ProductionPoubelle/fournisseur', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('fournisseur.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $fournisseur = Fournisseur::withTrashed()->where('id' ,  $id )->first();
        if (is_null($fournisseur)) {
            return $this->handleError('fournisseur n\'existe pas!');
        }else{
                $data= collect(Fournisseur::getFournisseurByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "nom"=> $data[0]['nom'],
                    "prenom"=> $data[0]['prenom'],
                    "CIN"=> $data[0]['CIN'],
                    "photo"=> $data[0]['photo'],
                    "numero_telephone"=> $data[0]['numero_telephone'],
                    "email"=> $data[0]['email'],
                    "adresse"=> $data[0]['adresse'],
                    "Liste_matieres"=> $data[0]['Liste_matieres'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/ProductionPoubelle/fournisseur', $liste);
                return $pdf->download('fournisseur.pdf');
            }
    }
}
