<?php

namespace App\Http\Controllers\Auth\Ouvrier;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Http\Requests\GestionCompte\OuvrierRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Ouvrier;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthOuvrierController extends BaseController{

    public function qrlogin($qrcode){
        $ouvrier = Ouvrier::where('QRcode',$qrcode)->first();
        if(!$ouvrier){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $ouvrier,
            'token'=> $ouvrier->createToken('ouvrier_login_qr')->plainTextToken,
        ],200);
    }

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

    public function sendFirstPassword(Request $request){
        $ouvrier = Ouvrier::where('email' , $request->email)->first();
        if($ouvrier){
            $mail_message = 'Ouvrier votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$ouvrier->email ,
                'fromName' => $ouvrier->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $ouvrier['mot_de_passe'] = Hash::make($pass);
            $ouvrier->save();
            return response([$ouvrier],200);
        }

        return response([],404);

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
