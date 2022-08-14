<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\ProductionPoubelle;
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
    public function exportInfoClientDechetExcel(){
        return Excel::download(new ClientDechetExport  , 'client-dechet-liste.xlsx');
    }

    public function exportInfoClientDechetCSV(){
        return Excel::download(new ClientDechetExport, 'client-dechet-liste.csv');
    }

    public function pdfClientDechet($id){
        $client = Client_dechet::find($id);
        if (is_null($client)) {
            return $this->handleError('client n\'existe pas!');
        }else{
            $data= collect(Client_dechet::getClientDechetById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'poubelle_id_resp' =>   $data[0]['poubelle_id_resp'],

                "etablissement" => $data[0]['etablissement'],
                "etablissement_id" =>  $data[0]['etablissement_id'],
                "nom" => $data[0]['nom'],
                "nom_poubelle_responsable" => $data[0]['nom_poubelle_responsable'],
                "type" => $data[0]['type'],
                "Etat" => $data[0]['Etat'],
                "quantite" => $data[0]['quantite'],
                "bloc_poubelle_id" => $data[0]['bloc_poubelle_id'],
                "bloc_poubelle_id_resp" => $data[0]['bloc_poubelle_id_resp'],
                "bloc_etablissement" => $data[0]['bloc_etablissement'],
                "bloc_etablissement_id" => $data[0]['bloc_etablissement_id'],

                "etage" => $data[0]['etage'],
                "etage_id" => $data[0]['etage_id'],
                "qrcode" => $data[0]['qrcode'],
                "created_at" => $data[0]['created_at'],
                "updated_at" => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/unique/GestionCompte/clientDechet', $liste);
            return $pdf->download('client-dechet.pdf');
        }
    }
    public function pdfAllClientDechet(){
        $client = Client_dechet::all();
        if (is_null($client)) {
            return $this->handleError('client dechet n\'existe pas!');
        }else{
            $p= Client_dechetResource::collection( $client);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/table/GestionCompte/clientDechet', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('client-dechet.pdf');
        }
    }
}
