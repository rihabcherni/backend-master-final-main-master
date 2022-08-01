<?php

namespace App\Http\Controllers\Auth\ResponsableEtablissement;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Responsable_etablissement;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AuthResponsableEtablissementController extends BaseController{
    public function allResponsableEtablissement(){
        $responsable = Responsable_etablissement::all();
        return response([
            'responsable_etablissements' => $responsable
        ]);
    }
    public function modifierPasswordResponsableEtablissement (Request $request){
        $responsable=auth()->guard('responsable_etablissement')->user();

        if(Auth::guard('responsable_etablissement') && (Hash::check($request->mot_de_passe, $responsable->mot_de_passe)) ){
                $responsable['mot_de_passe'] = Hash::make($request->newPassword);
                $responsable->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'verifier votre ancien mot de passe',
        ],403);
    }
    public function sendFirstPassword(Request $request){
        $responsable = Responsable_etablissement::where('email',$request->email)->first();
        if($responsable){
            $mail_message = 'responsable etablissement votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$responsable->email ,
                'fromName' => $responsable->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $responsable['mot_de_passe'] = Hash::make($pass);
            $responsable->save();
            return response([$responsable],200);
        }

        return response([],404);

    }

    public function sendImage(){
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

    public function destroyImage(){
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
    public function qrlogin($qrcode){
        $responsable = Responsable_etablissement::where('QRcode',$qrcode)->first();
        if(!$responsable){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $responsable,
            'token'=> $responsable->createToken('responsable-etablissement-login')->plainTextToken,
        ],200);
    }
}
