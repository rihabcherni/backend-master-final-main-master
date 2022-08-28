<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\Reparateur_poubelleExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Reparateur_poubelle as Reparateur_poubelleResource;
use App\Models\Reparateur_poubelle;
use App\Http\Requests\GestionCompte\Reparateur_poubelleRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\File;

class Reparateur_poubelleController extends BaseController{
    public function index(){
        $reparateur_poubelle = Reparateur_poubelle::all();
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelle), 'affichage des reparateurs poubelles');
    }
    public function store(Reparateur_poubelleRequest $request) {
        $input = $request->all();
        $reparateur_poubelle = Reparateur_poubelle::create($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle crée!');
    }
    public function show($id){
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle not found!');
        }else{
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle existe.');
        }
    }
    public function update(Reparateur_poubelleRequest $request, Reparateur_poubelle $reparateur_poubelle){
        $input = $request->all();
        $reparateur_poubelle->update($input);
        return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'reparateur poubelle modifié');
    }

    public function destroy($id) {
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle n\'existe pas!');
        }elseif($reparateur_poubelle->photo ==="default.jpeg" || $reparateur_poubelle->photo === NULL){
            $reparateur_poubelle->delete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé!');
        } else{
            if(File::exists(('storage\images\reparateur_poubelle\\').$reparateur_poubelle->photo)){
                File::copy(public_path('storage\images\reparateur_poubelle\\').$reparateur_poubelle->photo,
                public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo);
                unlink(public_path('storage\images\reparateur_poubelle\\').$reparateur_poubelle->photo );
            }
            $reparateur_poubelle->delete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé!');
        }
    }
    public function hdelete( $id) {
        $reparateur_poubelle = Reparateur_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle n\'existe pas!');
        }elseif($reparateur_poubelle->photo ==="default.jpeg" || $reparateur_poubelle->photo === NULL){
            $reparateur_poubelle->forceDelete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé!');
        } else{
            if(File::exists(('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo)){
                unlink(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo );
            }
            $reparateur_poubelle->forceDelete();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $reparateur_poubelles = Reparateur_poubelle::onlyTrashed()->get();
        foreach($reparateur_poubelles as $reparateur_poubelle){
            if($reparateur_poubelle->photo ==="default.jpeg" || $reparateur_poubelle->photo === NULL){
                $reparateur_poubelle->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo)){
                    unlink(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo );
                }
                $reparateur_poubelle->forceDelete();
            }
        }
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelles), 'tous reparateurs poubelles supprimés définitivement');
    }
    public function restore( $id) {
        $reparateur_poubelle = Reparateur_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle n\'existe pas!');
        }elseif($reparateur_poubelle->photo ==="default.jpeg" || $reparateur_poubelle->photo === NULL){
            $reparateur_poubelle->restore();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé!');
        } else{
            if(File::exists(('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo)){
                File::copy(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo,
                public_path('storage\images\reparateur_poubelle\\').$reparateur_poubelle->photo);
                unlink(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo );
            }
            $reparateur_poubelle->restore();
            return $this->handleResponse(new Reparateur_poubelleResource($reparateur_poubelle), 'Reparateur poubelle supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $reparateur_poubelles= Reparateur_poubelle::onlyTrashed()->get();
        foreach($reparateur_poubelles as $reparateur_poubelle){
            if($reparateur_poubelle->photo ==="default.jpeg" || $reparateur_poubelle->photo === NULL){
                $reparateur_poubelle->restore();
            } else{
                if(File::exists(('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo)){
                    File::copy(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo,
                    public_path('storage\images\reparateur_poubelle\\').$reparateur_poubelle->photo);
                    unlink(public_path('storage\trashImages\reparateur_poubelle\\').$reparateur_poubelle->photo );
                }
                $reparateur_poubelle->restore();
            }
        }
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelles), 'tous reparateurs poubelles trashed');
    }
    public function listeSuppression(){
        $reparateur_poubelle = Reparateur_poubelle::onlyTrashed()->get();
        return $this->handleResponse(Reparateur_poubelleResource::collection($reparateur_poubelle), 'affichage des reparateurs poubelles');
    }
    public function exportInfoExcel(){
        return Excel::download(new Reparateur_poubelleExport  , 'reparateur-poubelle-liste.xlsx');
    }

    public function exportInfoCSV(){
        return Excel::download(new Reparateur_poubelleExport, 'reparateur-poubelle-liste.csv');
    }

    public function pdf($id){
        $reparateur_poubelle = Reparateur_poubelle::find($id);
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle n\'existe pas!');
        }else{
            $data= collect(Reparateur_poubelle::getReparateurPoubelleById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "nom" => $data[0]['nom'],
                "prenom" => $data[0]['prenom'],
                "CIN" => $data[0]['CIN'],
                "photo" => $data[0]['photo'],
                "numero_telephone" => $data[0]['numero_telephone'],
                "email" => $data[0]['email'],
                "adresse" => $data[0]['adresse'],
                "Liste_poubelles_repares"=> $data[0]['Liste_poubelles_repares'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/reparateurPoubelle', $liste);
            return $pdf->download('reparateur-poubelle.pdf');
        }
    }
    public function pdfAll(){
        $reparateur_poubelle = Reparateur_poubelle::all();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle n\'existe pas!');
        }else{
            $p= Reparateur_poubelleResource::collection( $reparateur_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/reparateurPoubelle', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('reparateur-poubelle.pdf');
        }
    }
    public function pdfAllTrashed(){
        $reparateur_poubelle = Reparateur_poubelle::onlyTrashed()->get();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('Reparateur poubelle n\'existe pas!');
        }else{
            $p= Reparateur_poubelleResource::collection( $reparateur_poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionCompte/reparateurPoubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('Reparateur-poubelle.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $reparateur_poubelle = Reparateur_poubelle::withTrashed()->where('id' ,  $id )->first();
        if (is_null($reparateur_poubelle)) {
            return $this->handleError('reparateur poubelle n\'existe pas!');
        }else{
                $data= collect(Reparateur_poubelle::getReparateurPoubelleByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "nom" => $data[0]['nom'],
                    "prenom" => $data[0]['prenom'],
                    "CIN" => $data[0]['CIN'],
                    "photo" => $data[0]['photo'],
                    "numero_telephone" => $data[0]['numero_telephone'],
                    "email" => $data[0]['email'],
                    "adresse" => $data[0]['adresse'],
                    "Liste_poubelles_repares"=> $data[0]['Liste_poubelles_repares'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionCompte/reparateurPoubelle', $liste);
                return $pdf->download('Reparateur-poubelle.pdf');
            }
    }
}
