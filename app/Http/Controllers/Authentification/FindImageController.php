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

class FindImageController extends Controller{
    public function sendImageGest(){
        $gestionnaire=auth()->guard('gestionnaire')->user();

        if($gestionnaire !=null){
            if($gestionnaire->photo!=null){
                $destination = 'storage/images/Gestionnaire'.$gestionnaire->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>"undefiened gestionnaire"
        ],401);
    }

    public function sendImageOuvrier(){
        $ouvrier=auth()->guard('ouvrier')->user();

        if($ouvrier !=null){
            if($ouvrier->photo!=null){
                $destination = 'storage/images/ouvrier/'.$ouvrier->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>"undefiened ouvrier"
        ],401);
    }

    public function sendImageRComm(){
        $responsable_commercial=auth()->guard('responsable_commercial')->user();

        if($responsable_commercial !=null){
            if($responsable_commercial->photo!=null){
                $destination = 'storage/images/responsable_commercial/'.$responsable_commercial->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>"undefiened responsable_commercial"
        ],401);
    }

    public function sendImageRE(){
        $responsable=auth()->guard('responsable_etablissement')->user();

        if($responsable !=null){
            if($responsable->photo!=null){
                $destination = 'storage/images/responsable_etablissemet'.$responsable->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>"undefiened responsable"
        ],401);
    }

    public function sendImageRP(){
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($responsable_personnel !=null){
            if($responsable_personnel->photo!=null){
                $destination = 'storage/images/responsable_personnel/'.$responsable_personnel->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>'undefiened responsable_personnel'
        ],401);
    }
}
