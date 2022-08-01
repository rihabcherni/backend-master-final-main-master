<?php

namespace App\Http\Controllers\Auth\ResponsableCommercial;

use App\Models\Responsable_commercial;

use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
class ResponsableCommercialController extends BaseController{
    public function qrlogin($qrcode){
        $responsable_commercial = Responsable_commercial::where('QRcode',$qrcode)->first();
        if(!$responsable_commercial){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable_commercial,
            'token'=> $responsable_commercial->createToken('responsable_commercial_login_qr')->plainTextToken,
        ],200);
    }

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

    public function sendFirstPassword(Request $request){
        $responsable_commercial = Responsable_commercial::where('email' , $request->email)->first();
        if($responsable_commercial){
            $mail_message = 'responsable commercial votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable_commercial->email ,
                'fromName' => $responsable_commercial->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable_commercial['mot_de_passe'] = Hash::make($pass);
            $responsable_commercial->save();
            return response([$responsable_commercial],200);
        }

        return response([],404);

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
