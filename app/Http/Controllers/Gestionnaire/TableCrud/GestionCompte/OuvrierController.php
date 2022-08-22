<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionCompte;

use App\Exports\GestionCompte\OuvrierExport;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionCompte\Ouvrier as OuvrierResource;
use App\Models\Ouvrier;
use Illuminate\Support\Str;
use App\Http\Controllers\Globale\LoginController;
use App\Http\Requests\GestionCompte\OuvrierRequest;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class OuvrierController extends BaseController{
    public function index(){
        $ouvrier = Ouvrier::all();
        return $this->handleResponse(OuvrierResource::collection($ouvrier), 'Affichage des Ouvriers!');
    }

    public function store(OuvrierRequest $request){
        $input = $request->all();
        $pass = Str::random(8);
        $pass = Str::random(8);
        $SendEmail = new LoginController;
        $mp=$SendEmail->sendFirstPassword( $input['email'], $input['nom'], $input['prenom'],$pass);
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }
        $input['mot_de_passe'] =  Hash::make($mp->getData()->mot_de_passe);
        $input['QRcode'] =  Hash::make($mp->getData()->mot_de_passe);
        $ouvrier = Ouvrier::create($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier crée!');
    }

    public function show($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier existe.');
        }
    }
    public function update(OuvrierRequest $request, Ouvrier $ouvrier){
        $input = $request->all();
        if ($image = $request->file('photo')) {
            $destinationPath = 'storage/images/ouvrier';
            $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $profileImage);
            $input['photo'] = "$profileImage";
        }else{
            unset($input['photo']);
        }
        if(!($request->mot_de_passe==null)){
            $input['mot_de_passe'] = Hash::make($input['mot_de_passe']);
        }

        $ouvrier->update($input);
        return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier modifié!');
    }
    public function destroy($id) {
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }
        else{
            if($ouvrier->photo){
                unlink(public_path('storage\images\ouvrier\\').$ouvrier->photo );
            }
            $ouvrier->delete();
            return $this->handleResponse(new OuvrierResource($ouvrier), 'Ouvrier supprimé!');
        }
    }

    public function exportInfoOuvrierExcel(){
        return Excel::download(new OuvrierExport  , 'ouvrier-liste.xlsx');
    }
    public function exportInfoOuvrierCSV(){
        return Excel::download(new OuvrierExport, 'ouvrier-liste.csv');
    }
    public function pdfOuvrier($id){
        $ouvrier = Ouvrier::find($id);
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            $data= collect(Ouvrier::getOuvrierById($id))->toArray();
            $liste = [
                'id' => $data[0]['id'],
                'camion_id' => $data[0]['camion_id'],
                'matricule' => $data[0]['matricule'],
                'poste' => $data[0]['poste'],
                'nom' => $data[0]['nom'],
                'prenom' => $data[0]['prenom'],
                'adresse' => $data[0]['adresse'],
                'CIN' => $data[0]['CIN'],
                'photo' => $data[0]['photo'],
                'numero_telephone' => $data[0]['numero_telephone'],
                'email' => $data[0]['email'],
                'created_at' => $data[0]['created_at'],
                'updated_at' => $data[0]['updated_at'],
            ];
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionCompte/ouvrier', $liste);
            return $pdf->download('ouvrier.pdf');
        }
    }
    public function pdfAllOuvrier(){
        $ouvrier = Ouvrier::all();
        if (is_null($ouvrier)) {
            return $this->handleError('ouvrier n\'existe pas!');
        }else{
            $p= OuvrierResource::collection( $ouvrier);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionCompte/ouvrier', [ 'data' => $data] )->setPaper('a3', 'landscape');
            return $pdf->download('ouvrier.pdf');
        }
    }
}
