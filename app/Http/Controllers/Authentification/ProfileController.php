<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
class ProfileController extends Controller{
    public function profile(){
        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $client_dechet=auth()->guard('client_dechet')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($gestionnaire !=null){
            return $gestionnaire;
        }else if($responsable_etab !=null){
           return $responsable_etab;
        }else if($client_dechet !=null){
           return $client_dechet;
        }else if($ouvrier !=null){
           return $ouvrier;
        }else if($responsable_commerciale !=null){
           return $responsable_commerciale;
        }else if($responsable_personnel !=null){
           return $responsable_personnel;
        }else{
            return response([
                'status' => 404,
                'photo' =>'error',
            ],404);
        }

    }
}
