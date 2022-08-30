<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
use App\Http\Resources\GestionCompte\Client_dechet as GestionCompteClient_dechet;
use App\Http\Resources\GestionCompte\Gestionnaire as GestionCompteGestionnaire;
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
use Illuminate\Support\Facades\File;

class DestroyImageController extends Controller{


    public function destroyImageGestionnaire(){

        $gestionnaire=auth()->guard('gestionnaire')->user();

        if($gestionnaire !=null){
            $destination = 'storage/images/Gestionnaire/'.$gestionnaire->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $gestionnaire->photo = null;
                    $gestionnaire->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$gestionnaire,
                ]);
        }
    }

    public function destroyImageOuvrier(){
        $ouvrier=auth()->guard('ouvrier')->user();

        if($ouvrier !=null){

            $destination = 'storage/images/ouvrier/'.$ouvrier->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $ouvrier->photo = null;
                    $ouvrier->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$ouvrier,
                ]);
        }
    }

    public function destroyImageRC(){
        $responsable_commercial=auth()->guard('responsable_commercial')->user();

        if($responsable_commercial !=null){

            $destination = 'storage/images/responsable_commercial/'.$responsable_commercial->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable_commercial->photo = null;
                    $responsable_commercial->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable_commercial,
                ]);
        }
    }

    public function destroyImageRE(){
        $responsable=auth()->guard('responsable_etablissement')->user();
        if($responsable !=null){
            $destination = 'storage/images/responsable_etablissement/'.$responsable->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable->photo = null;
                    $responsable->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable,
                ]);
        }
    }

    public function destroyImageRP(){
        $responsable_personnel=auth()->guard('responsable_personnel')->user();
        if($responsable_personnel !=null){
            $destination = 'storage/images/responsable_personnel/'.$responsable_personnel->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable_personnel->photo = null;
                    $responsable_personnel->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable_personnel,
                ]);
        }
    }
}
