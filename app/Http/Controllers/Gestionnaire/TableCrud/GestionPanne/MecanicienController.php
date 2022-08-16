<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPanne;

use App\Exports\GestionPanne\MecanicienExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPanne\Mecanicien as MecanicienResource;
use App\Models\Mecanicien;
use App\Http\Requests\GestionPanne\MecanicienRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $mecanicien =Mecanicien::find($id);
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }
        else{
            $mecanicien->delete();
            return $this->handleResponse(new MecanicienResource($mecanicien), 'Mecanicien supprimé!');
        }
    }
    public function exportInfoMecanicienExcel(){
        return Excel::download(new MecanicienExport  , 'mecanicien-liste.xlsx');
    }

    public function exportInfoMecanicienCSV(){
        return Excel::download(new MecanicienExport, 'mecanicien-liste.csv');
    }

    public function pdfMecanicien($id){
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
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionPanne/mecanicien', $liste);
            return $pdf->download('mecanicien.pdf');
        }
    }
    public function pdfAllMecanicien(){
        $mecanicien = Mecanicien::all();
        if (is_null($mecanicien)) {
            return $this->handleError('mecanicien n\'existe pas!');
        }else{
            $p= MecanicienResource::collection( $mecanicien);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionPanne/mecanicien', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('mecanicien.pdf');
        }
    }
}
