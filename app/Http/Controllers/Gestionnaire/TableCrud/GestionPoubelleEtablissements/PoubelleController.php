<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;
use App\Models\Poubelle;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\GestionPoubelleEtablissements\PoubelleRequest;
use App\Exports\GestionPoubelleEtablissements\PoubelleExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
class PoubelleController extends BaseController{
    public function index(){
        $poubelle = Poubelle::all();
        return $this->handleResponse(PoubelleResource::collection($poubelle), 'Tous les poubelles!');
    }
    public function store(PoubelleRequest $request){
        $input = $request->all();
        $last_id=Poubelle::count()+1;
        $poubelleNom=$request->etablissement_id.'-'.$request->bloc_etablissement_id.'-E'.$request->etage_etablissement_id.'-BP'.$request->bloc_poubelle_id.'-N'.$last_id;
        $qrcode= Hash::make($poubelleNom);
        $input['QRcode']=  $qrcode;
        $input['nom']=  $poubelleNom;
        $poubelle = Poubelle::create($input);
        return $this->handleResponse(new PoubelleResource($poubelle),'poubelle crée!');
    }
    public function show($id){
        $poubelle = Poubelle::find($id);
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }else{
            return $this->handleResponse(new PoubelleResource($poubelle), 'poubelle existe');
        }
    }
    public function update(PoubelleRequest $request, Poubelle $poubelle){
        $input = $request->all();
        $nom= $poubelle->nom;

        $posEtab =strpos($nom,'-');
        $etab= substr($nom,0,$posEtab) ;
        if($request->has('etablissement_id')) {
            $etab=  $request->etablissement_id;
        };
        $nom= substr($nom,$posEtab+1 );

        $posblocEtab= strpos($nom, '-');
        $bloc_etab=  substr($nom,0,$posblocEtab) ;
        if($request->has('bloc_etablissement_id')) {
            $bloc_etab=  $request->bloc_etablissement_id;
        };

        $nom= substr($nom,$posblocEtab+1 );

        $posEtage= strpos($nom, '-');
        $etage=  substr($nom,1,$posEtage-1) ;
        if($request->has('etage_etablissement_id')) {
            $etage=  $request->etage_etablissement_id;
        };

        $nom= substr($nom,$posEtage+1 );

        $posBlocPoubelle= strpos($nom, '-');
        $blocPouelle=  substr($nom,2,$posBlocPoubelle-2) ;
        if($request->has('bloc_poubelle_id')) {
            $blocPouelle=  $request->bloc_poubelle_id;
        };
        $id= substr($nom,$posBlocPoubelle+2 );
        $poubelleNom=$etab.'-'.$bloc_etab.'-E'.$etage.'-BP'.$blocPouelle.'-N'.$id;
        $qrcode= Hash::make($poubelleNom);
        $input['QRcode']=  $qrcode;
        $input['nom']=  $poubelleNom;
        $poubelle->update($input);
        return $this->handleResponse(new PoubelleResource($poubelle), ' poubelle modifié!');
    }
    public function destroy($id){
        $poubelle =Poubelle::find($id);
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }
        else{
            $poubelle->delete();
            return $this->handleResponse(new PoubelleResource($poubelle), ' poubelle supprimé!');
        }
    }

    public function exportInfoPoubelleExcel(){
        return Excel::download(new PoubelleExport, 'poubelleliste.xlsx');
    }

    public function exportInfoPoubelleCSV(){
        return Excel::download(new PoubelleExport, 'poubelleliste.csv');
    }

    public function pdfPoubelle($id){
        $poubelle = Poubelle::find($id);
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }else{
            $data= collect(Poubelle::getPoubelleById($id))->toArray();
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
            $pdf = Pdf::loadView('pdf/NoDelete/unique/GestionPoubelleEtablissement/poubelle', $liste);
            return $pdf->download('poubelle.pdf');
        }
    }
    public function pdfAllPoubelle(){
        $poubelle = Poubelle::all();
        if (is_null($poubelle)) {
            return $this->handleError('poubelle n\'existe pas!');
        }else{
            $p= PoubelleResource::collection( $poubelle);
            $data= collect($p)->toArray();
            $pdf = Pdf::loadView('pdf/NoDelete/table/GestionPoubelleEtablissement/poubelle', [ 'data' => $data] )->setPaper('a4', 'landscape');
            return $pdf->download('poubelle.pdf');
        }
    }
}
