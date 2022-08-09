<?php

namespace App\Http\Controllers\Auth\Ouvrier;
use Illuminate\Http\Request;
use App\Http\Controllers\Globale\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Ouvrier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;

class AuthOuvrierController extends BaseController{
    public function allOuvriers(){
        $ouvrier = Ouvrier::all();
        return response([
            'ouvrier' => $ouvrier
        ]);
    }

    public function modifierPasswordOuvrier (Request $request , $email){
        $ouvrier=Ouvrier::where('email',$email)->first();

        if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe, $ouvrier->mot_de_passe)) ){
                $ouvrier['mot_de_passe'] = Hash::make($request->newPassword);
                $ouvrier->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendImage(){
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

    public function destroyImage(){
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
}
