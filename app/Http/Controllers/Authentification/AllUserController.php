<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
use App\Http\Resources\GestionCompte\Client_dechet as GestionCompteClient_dechet;
use App\Http\Resources\GestionCompte\Gestionnaire as GestionCompteGestionnaire;
use App\Http\Resources\GestionCompte\Mecanicien as GestionCompteMecanicien;
use App\Http\Resources\GestionCompte\Ouvrier as GestionCompteOuvrier;
use App\Http\Resources\GestionCompte\Reparateur_poubelle as GestionCompteReparateur_poubelle;
use App\Http\Resources\GestionCompte\Responsable_commercial as GestionCompteResponsable_commercial;
use App\Http\Resources\GestionCompte\Responsable_etablissement as GestionCompteResponsable_etablissement;
use App\Http\Resources\GestionCompte\Responsable_personnel as GestionCompteResponsable_personnel;
use App\Http\Resources\GestionCompte\Responsable_technique as GestionCompteResponsable_technique;
use App\Models\Client_dechet;
use App\Models\Forget_password;
use Illuminate\Support\Facades\Validator;
use App\Models\Gestionnaire;
use App\Models\Mecanicien;
use App\Models\Ouvrier;
use App\Models\Reparateur_poubelle;
use App\Models\Responsable_commercial;
use App\Models\Responsable_etablissement;
use App\Models\Responsable_personnel;
use App\Models\Responsable_technique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class AllUserController extends Controller{
    public function allClientDechets(){
        return response([ 'client_dechets' => GestionCompteClient_dechet::collection(Client_dechet::all()),]);
    }
    public function allGestionnaire(){
        return response([ 'gestionnaire' => GestionCompteGestionnaire::collection(Gestionnaire::all()),]);
    }
    public function allOuvriers(){
        return response([ 'ouvrier' => GestionCompteOuvrier::collection(Ouvrier::all())]);
    }
    public function allResponsableCommercial(){
        return response(['responsable_commercial' => GestionCompteResponsable_commercial::collection(Responsable_commercial::all()) ]);
    }
    public function allResponsableEtablissement(){
        return response(['responsable_etablissements' => GestionCompteResponsable_etablissement::collection(Responsable_etablissement::all())]);
    }
    public function allResponsablePersonnels(){
        return response(['responsable_personnel' =>GestionCompteResponsable_personnel::collection(Responsable_personnel::all())]);
    }
    public function allResponsableTechnique(){
        return response(['responsable_technique' =>GestionCompteResponsable_technique::collection(Responsable_technique::all())]);
    }
    public function allMecanicien(){
        return response([ 'mecanicien' => GestionCompteMecanicien::collection(Mecanicien::all()),]);
    }
    public function allReparateur_poubelle(){
        return response([ 'reparateur_poubelles' => GestionCompteReparateur_poubelle::collection(Reparateur_poubelle::all()),]);
    }
}
