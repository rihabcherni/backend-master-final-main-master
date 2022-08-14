<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Responsable_personnel as Responsable_personnelResource;
use App\Http\Requests\GestionCompte\ResponsablePersonnelRequest;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Models\Responsable_personnel;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class ResponsablePersonnelController extends BaseController{
    public function index(){
        $responsablePersonnel = Responsable_personnel::all();
        return $this->handleResponse(Responsable_personnelResource::collection($responsablePersonnel), 'Affichage des responsable personnel!');
    }

    public function store(ResponsablePersonnelRequest $request)  {
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
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
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement crée!');
    }
    public function show($id){
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }else{
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement existe.');
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
        return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement modifié!');
    }
    public function destroy($id) {
        $responsablePersonnel = Responsable_personnel::find($id);
        if (is_null($responsablePersonnel)) {
            return $this->handleError('responsable Etablissement n\'existe pas!');
        }
        else{
            if($responsablePersonnel->photo){
                unlink(public_path('storage\images\responsable_personnel\\').$responsablePersonnel->photo );
            }
            $responsablePersonnel->delete();
            return $this->handleResponse(new Responsable_personnelResource($responsablePersonnel), 'responsable Etablissement supprimé!');
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
