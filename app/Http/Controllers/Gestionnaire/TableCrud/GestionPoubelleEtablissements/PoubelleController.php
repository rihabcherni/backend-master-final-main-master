<?php
namespace App\Http\Controllers\Gestionnaire\TableCrud\GestionPoubelleEtablissements;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;
use App\Models\Poubelle;
use App\Models\Bloc_etablissement;
use Illuminate\Support\Facades\Hash;
use App\Models\Etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etage_etablissement;
use App\Http\Requests\GestionPoubelleEtablissements\PoubelleRequest;
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
}
