<?php

namespace App\Http\Controllers\Auth\Ouvrier;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Ouvrier;
use Illuminate\Support\Facades\File;

class AuthOuvrierController extends BaseController{
    public function allOuvriers(){
        $ouvrier = Ouvrier::all();
        return response([
            'ouvrier' => $ouvrier
        ]);
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
