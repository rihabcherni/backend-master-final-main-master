<?php
namespace App\Http\Controllers\Auth\Gestionnaire;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\File;

class AuthGestionnaireController extends BaseController{
    public function allGestionnaire(){
        $gestionnaire = Gestionnaire::all();
        return response([
            'gestionnaire' => $gestionnaire
        ]);
    }

    public function sendImage(){
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

    public function destroyImage(){

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

}
