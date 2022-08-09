<?php

namespace App\Http\Controllers\Auth\ResponsableCommercial;

use App\Models\Responsable_commercial;
use App\Http\Controllers\Globale\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
class ResponsableCommercialController extends BaseController{
    public function allResponsableCommercials(){
        $responsable_commercial = Responsable_commercial::find(1);
        return response([
            'responsable_commercial' => $responsable_commercial
        ]);
    }


    public function modifierPasswordResponsableCommercial (Request $request , $email){
        $responsable_commercial=Responsable_commercial::where('email',$email)->first();

        if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe, $responsable_commercial->mot_de_passe)) ){
                $responsable_commercial['mot_de_passe'] = Hash::make($request->newPassword);
                $responsable_commercial->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendImage(){
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

    public function destroyImage(){
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
}
