<?php
namespace App\Http\Controllers\API\GestionPoubelleEtablissements;
use App\Http\Controllers\BaseController as BaseController;
use App\Http\Resources\GestionPoubelleEtablissements\Poubelle as PoubelleResource;
use App\Models\Poubelle;
use App\Models\Bloc_etablissement;
use Illuminate\Support\Facades\Hash;
use App\Models\Etablissement;
use App\Models\Bloc_poubelle;
use App\Models\Etage_etablissement;
use App\Http\Resources\GestionPoubelleEtablissements\Etablissement as EtablissementResource;
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
        $poubelleNom=$etab.'-'.$bloc_etab.'-E'.$etage.'-BP'.$blocPouelle.'-N';
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
    // public function etablissementAllDetails() {
    //     $etablissement = Etablissement::all();
    //     $etab= EtablissementResource::collection($etablissement)->values() ;
    //     $liste=[];
    //     $bloc_etab=[];
    //     foreach($etab as $e){
    //         $id= $e->id;
    //         $nom_etablissement= $e->nom_etablissement;
    //         $bloc_etablissements= $e->bloc_etablissements;
    //         foreach($bloc_etablissements as $bEtab){
    //             $etage= Etage_etablissement::where("bloc_etablissement_id",$bEtab->id)->pluck("nom_etage_etablissement");
    //           array_push($bloc_etab,["nom_bloc_etablissement"=>$bEtab->nom_bloc_etablissement,"etage"=> $etage] );
    //         }
    //         array_push($liste , ["id"=>$id,"nom_etablissement"=> $nom_etablissement,"bloc_etablissements"=>$bloc_etab]);
    //     }
    //     return $liste;
    // }
    public function etablissementAllDetails() {
        $etablissement = Etablissement::all();
        $etab= EtablissementResource::collection($etablissement)->values() ;
        $liste=[];
        $bloc_etab=[];
        foreach($etab as $e){
            $id= $e->id;
            $nom_etablissement= $e->nom_etablissement;
            $bloc_etablissements= $e->bloc_etablissements;
            foreach($bloc_etablissements as $bEtab){
                $etage= Etage_etablissement::where("bloc_etablissement_id",$bEtab->id)->pluck("nom_etage_etablissement");
              array_push($bloc_etab,["nom_bloc_etablissement"=>$bEtab->nom_bloc_etablissement,"etage"=> $etage] );
            }
            array_push($liste , ["id"=>$id,"nom_etablissement"=> $nom_etablissement,"bloc_etablissements"=>$bloc_etab]);
        }
        return $liste;
    }

    public function BlocEtablissementListe($etab){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $bloc_etab= Bloc_etablissement::where('etablissement_id', $etab_id)->pluck("nom_bloc_etablissement");
        return $bloc_etab;
    }

    public function EtageEtablissementListe($etab, $bloc_etab){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $id_bloc_etablissement= Bloc_etablissement::where("etablissement_id",$etab_id)->where('nom_bloc_etablissement', $bloc_etab)->pluck("id");
        $etage= Etage_etablissement::where("bloc_etablissement_id", $id_bloc_etablissement)->pluck("nom_etage_etablissement"); 
        return $etage;
    }

    public function  BlocPoubelleListe($etab, $bloc_etab, $etage){
        $etab_id= Etablissement::where("nom_etablissement", $etab)->first()->id;
        $id_bloc_etablissement= Bloc_etablissement::where("etablissement_id",$etab_id)->where('nom_bloc_etablissement', $bloc_etab)->pluck("id");
        $id_etage= Etage_etablissement::where("bloc_etablissement_id",$id_bloc_etablissement)->where('nom_etage_etablissement', $etage)->pluck("id");
        $bloc_poubelle= Bloc_poubelle::where("etage_etablissement_id", $id_etage)->pluck("id"); 
        return $bloc_poubelle;
    }
}
