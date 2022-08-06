<?php

namespace App\Http\Controllers\Auth\ResponsablePersonnel;

use App\Models\Responsable_personnel;
use Illuminate\Http\Request;
use App\Http\Controllers\Globale\BaseController as BaseController;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
class ResponsablePersonnelController extends BaseController{
    public function qrlogin($qrcode){
        $responsable_personnel = Responsable_personnel::where('QRcode',$qrcode)->first();
        if(!$responsable_personnel){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable_personnel,
            'token'=> $responsable_personnel->createToken('responsable_personnel_login_qr')->plainTextToken,
        ],200);
    }

    public function allResponsablePersonnels(){
        $responsable_personnel = Responsable_personnel::find(1);
        return response([
            'responsable_personnel' => $responsable_personnel
        ]);
    }

    public function modifierPasswordResponsablePersonnel (Request $request , $email){
        $responsable_personnel=Responsable_personnel::where('email',$email)->first();

        if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe, $responsable_personnel->mot_de_passe)) ){
                $responsable_personnel['mot_de_passe'] = Hash::make($request->newPassword);
                $responsable_personnel->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }

    public function sendFirstPassword(Request $request){
        $responsable_personnel = Responsable_personnel::where('email' , $request->email)->first();
        if($responsable_personnel){
            $mail_message = 'responsable Personnel votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable_personnel->email ,
                'fromName' => $responsable_personnel->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable_personnel['mot_de_passe'] = Hash::make($pass);
            $responsable_personnel->save();
            return response([$responsable_personnel],200);
        }
        return response([],404);
    }

    public function sendImage(){
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

    public function destroyImage(){
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
