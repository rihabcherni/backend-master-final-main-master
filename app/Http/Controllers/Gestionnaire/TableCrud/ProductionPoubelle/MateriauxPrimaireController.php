<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;

use App\Exports\ProductionPoubelle\MateriauxPrimaireExport;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\ProductionPoubelle\MateriauxPrimaire as MateriauxPrimaireResource;
use App\Models\Materiau_primaire;
use App\Http\Requests\ProductionPoubelle\MateriauxPrimaireRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class MateriauxPrimaireController extends BaseController{
    public function index(){
        $materiauxPrimaire = Materiau_primaire::all();
        return $this->handleResponse(MateriauxPrimaireResource::collection($materiauxPrimaire), 'Affichage des materiauxPrimaire');
    }
    public function store(MateriauxPrimaireRequest $request){
        $input = $request->all();
        $materiauxPrimaire = Materiau_primaire::create($input);
        return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau primaire crée!');
    }
    public function show($id){
        $materiauxPrimaire = Materiau_primaire::find($id);
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiau Primaire not found!');
        }else{
            return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau Primaire existe.');
        }
    }
    public function update(MateriauxPrimaireRequest $request, Materiau_primaire $materiauxPrimaire){
        $input = $request->all();
        $materiauxPrimaire->update($input);
        return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), ' materiau Primaire modifié!');
    }
    public function destroy($id){
        $materiauxPrimaire =Materiau_primaire::find($id);
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiaux Primaire n\'existe pas!');
        }
        else{
            $materiauxPrimaire->delete();
            return $this->handleResponse(new MateriauxPrimaireResource($materiauxPrimaire), 'materiau Primaire supprimé!');
        }
    }
    public function exportInfoMateriauxPrimaireExcel(){
        return Excel::download(new MateriauxPrimaireExport  , 'materiaux-primaire-liste.xlsx');
    }
    public function exportInfoMateriauxPrimaireCSV(){
        return Excel::download(new MateriauxPrimaireExport, 'materiaux-primaire-liste.csv');
    }
    public function pdfMateriauxPrimaire($id){
        $materiauxPrimaire = Materiau_primaire::find($id);
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiaux primaire n\'existe pas!');
        }else{
            $data= collect(Materiau_primaire::getMateriauxPrimaireById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                "fournisseur_id" => $data[0]['fournisseur_id'],
                "fournisseur" => $data[0]['fournisseur'],
                "fournisseur_nom" => $data[0]['fournisseur_nom'],
                "cin" => $data[0]['cin'],
                "fournisseur_numero_telephone" => $data[0]['fournisseur_numero_telephone'],
                "nom_materiel" => $data[0]['nom_materiel'],
                "prix_unitaire" => $data[0]['prix_unitaire'],
                "quantite" => $data[0]['quantite'],
                "prix_total" => $data[0]['prix_total'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/ProductionPoubelle/materiauxPrimaires', $liste);
            return $pdf->download('materiaux-primaire.pdf');
        }
    }
    public function pdfAllMateriauxPrimaire(){
        $materiauxPrimaire = Materiau_primaire::all();
        if (is_null($materiauxPrimaire)) {
            return $this->handleError('materiaux primaire n\'existe pas!');
        }else{
            $p= MateriauxPrimaireResource::collection( $materiauxPrimaire);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/ProductionPoubelle/materiauxPrimaires', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('materiaux-primaire.pdf');
        }
    }
}
