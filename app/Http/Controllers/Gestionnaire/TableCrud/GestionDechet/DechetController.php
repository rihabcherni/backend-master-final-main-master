<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionDechet;

use App\Exports\GestionDechet\DechetExport;
use App\Models\Commande_dechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;
use App\Models\Dechet;
use App\Http\Requests\GestionDechet\DechetRequest;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
Use \Carbon\Carbon;
use Illuminate\Support\Facades\File;

class DechetController extends BaseController{
    public function index(){
        $dechet = Dechet::all();
        return $this->handleResponse(DechetResource::collection($dechet), 'tous les dechets!');
    }
    public function store(DechetRequest $request){
        $input = $request->all();
        $dechet = Dechet::create($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet crée!');
    }
    public function show($id){
        $dechet = Dechet::find($id);
        if (count($dechet)==0) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            return $this->handleResponse(new DechetResource($dechet), 'dechet existante.');
        }
    }
    public function update(DechetRequest $request, Dechet $dechet){
        $input = $request->all();
        $dechet->update($input);
        return $this->handleResponse(new DechetResource($dechet), 'dechet modifié!');
    }
    public function destroy($id) {
        $dechet = Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }elseif($dechet->photo ==="default.jpeg" || $dechet->photo === NULL){
            $dechet->delete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        } else{
            if(File::exists(('storage\images\dechet\\').$dechet->photo)){
                File::copy(public_path('storage\images\dechet\\').$dechet->photo,
                public_path('storage\trashImages\dechet\\').$dechet->photo);
                unlink(public_path('storage\images\dechet\\').$dechet->photo );
            }
            $dechet->delete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        }
    }

    public function hdelete( $id) {
        $dechet = Dechet::withTrashed()->where('id' ,  $id )->first();
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }elseif($dechet->photo ==="default.jpeg" || $dechet->photo === NULL){
            $dechet->forceDelete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        } else{
            if(File::exists(('storage\trashImages\dechet\\').$dechet->photo)){
                unlink(public_path('storage\trashImages\dechet\\').$dechet->photo );
            }
            $dechet->forceDelete();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé definitivement!');
        }
    }
    public function hdeleteAll( ) {
        $dechets = Dechet::onlyTrashed()->get();
        foreach($dechets as $dechet){
            if($dechet->photo ==="default.jpeg" || $dechet->photo === NULL){
                $dechet->forceDelete();
            } else{
                if(File::exists(('storage\trashImages\dechet\\').$dechet->photo)){
                    unlink(public_path('storage\trashImages\dechet\\').$dechet->photo );
                }
                $dechet->forceDelete();
            }
        }
        return $this->handleResponse(DechetResource::collection($dechets), 'tous dechets supprimés définitivement');
    }
    public function restore( $id) {
        $dechet = Dechet::withTrashed()->where('id' ,  $id )->first();
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }elseif($dechet->photo ==="default.jpeg" || $dechet->photo === NULL){
            $dechet->restore();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé!');
        } else{
            if(File::exists(('storage\trashImages\dechet\\').$dechet->photo)){
                File::copy(public_path('storage\trashImages\dechet\\').$dechet->photo,
                public_path('storage\images\dechet\\').$dechet->photo);
                unlink(public_path('storage\trashImages\dechet\\').$dechet->photo );
            }
            $dechet->restore();
            return $this->handleResponse(new DechetResource($dechet), 'dechet supprimé avec retour!');
        }
    }
    public function restoreAll(){
        $dechets= Dechet::onlyTrashed()->get();
        foreach($dechets as $dechet){
            if($dechet->photo ==="default.jpeg" || $dechet->photo === NULL){
                $dechet->restore();
            } else{
                if(File::exists(('storage\trashImages\dechet\\').$dechet->photo)){
                    File::copy(public_path('storage\trashImages\dechet\\').$dechet->photo,
                    public_path('storage\images\dechet\\').$dechet->photo);
                    unlink(public_path('storage\trashImages\dechet\\').$dechet->photo );
                }
                $dechet->restore();
            }
        }
        return $this->handleResponse(DechetResource::collection($dechets), 'tous dechets trashed');
    }
    public function listeSuppression(){
        $dechet = Dechet::onlyTrashed()->get();
        return $this->handleResponse(DechetResource::collection($dechet), 'affichage des dechets');
    }



    // public function panier(Request $request){
    //     $myArray = array();
    //     $json = utf8_decode($request->commande);
    //     $data = json_decode($json,true);
    //     $bool = false;
    //     // $len = count($data);

    //     // $id_dechets = $data[0]['type']['id'];
    //     // $qte_dechets = data[0]['qte'];

    //     // $id = $request->id;
    //     // $prix_totals = json_decode($request->prix_total);

    //     $cmd=Dechet::create([
    //         'client_dechet_id' => $request->id_client,
    //         "type_paiment"=> $request->type_paiment,
    //         'montant_total'=>$request->montant_total,
    //         'date_commande' => Carbon::now()->translatedFormat('H:i:s j F Y')
    //     ]);

    //     if(count($data)>1){
    //         for ($i=0; $i <count($data) ; $i++){
    //             Commande_dechet::create([
    //                 'commande_dechet_id' => $cmd->id,
    //                 'dechet_id' => $data[$i]['type']['id'],
    //                 'quantite' => $data[$i]['qte'],
    //             ]);
    //         }
    //     }else{
    //             Commande_dechet::create([
    //             'commande_dechet_id' => $cmd->id,
    //             'dechet_id' => $data[0]['type']['id'],
    //             'quantite' => $data[0]['qte'],
    //         ]);
    //     }

    //     return response([
    //         // "prix_total" => $prix_totals[0]->prix_total,
    //         // "data" => $data,
    //         // "myArrayCount" => count($myArray),
    //         // "myArray" => $myArray,
    //         'cmd' => $cmd,
    //         'id_cmd' => $cmd->id,
    //         'bool' => $bool
    //     ]);
    // }
    public function exportInfoDechetExcel(){
        return Excel::download(new DechetExport  , 'dechet-liste.xlsx');
    }

    public function exportInfoDechetCSV(){
        return Excel::download(new DechetExport, 'dechet-liste.csv');
    }
    public function pdfDechet($id){
        $dechet = Dechet::find($id);
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            $data= collect(Dechet::getDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "type_dechet"  => $data[0]['type_dechet'],
                "prix_unitaire" => $data[0]['prix_unitaire'],
                "pourcentage_remise" => $data[0]['pourcentage_remise'],
                "photo" => $data[0]['photo'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionDechet/Dechet', $liste);
            return $pdf->download('dechet.pdf');
        }
    }
    public function pdfAllDechet(){
        $dechet = Dechet::all();
        if (is_null($dechet)) {
            return $this->handleError('Dechet n\'existe pas!');
        }else{
            $p= DechetResource::collection( $dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionDechet/Dechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('dechet.pdf');
        }
    }
    public function pdfAllTrashed(){
        $dechet = Dechet::onlyTrashed()->get();
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
            $p= DechetResource::collection( $dechet);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/Delete/table/GestionDechet/dechet', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('dechet.pdf');
        }
    }
    public function pdfTrashed( $id) {
        $dechet = Dechet::withTrashed()->where('id' ,  $id )->first();
        if (is_null($dechet)) {
            return $this->handleError('dechet n\'existe pas!');
        }else{
                $data= collect(Dechet::getDechetByIdTrashed($id))->toArray();
                $liste = [
                    'id' => $data[0]['id'],
                    "type_dechet"  => $data[0]['type_dechet'],
                    "prix_unitaire" => $data[0]['prix_unitaire'],
                    "pourcentage_remise" => $data[0]['pourcentage_remise'],
                    "photo" => $data[0]['photo'],
                    "created_at" => $data[0]['created_at'],
                    "updated_at" => $data[0]['updated_at'],
                    'deleted_at' => $data[0]['deleted_at'],
                ];
                $pdf = Pdf::loadView('pdf/Delete/unique/GestionDechet/dechet', $liste);
                return $pdf->download('dechet.pdf');
            }
    }
}
