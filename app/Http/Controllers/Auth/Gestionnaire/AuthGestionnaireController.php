<?php
namespace App\Http\Controllers\Auth\Gestionnaire;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Globale\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Gestionnaire;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class AuthGestionnaireController extends BaseController{
    public function allGestionnaire(){
        $gestionnaire = Gestionnaire::all();
        return response([
            'gestionnaire' => $gestionnaire
        ]);
    }

    public function modifierPasswordGestionnaire (Request $request ){
        $gestionnaire=auth()->guard('gestionnaire')->user();

        if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe, $gestionnaire->mot_de_passe)) ){
                $gestionnaire['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $gestionnaire->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'verifier votre ancien mot de passe',
        ],403);
    }
    public function sendFirstPassword(Request $request){
        $gestionnaire = Gestionnaire::where('email',$request->email)->first();
        if($gestionnaire){
            $mail_message = 'Gestionnaire votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$gestionnaire->email ,
                'fromName' => $gestionnaire->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $gestionnaire['mot_de_passe'] = Hash::make($pass);
            $gestionnaire->save();
            return response([$gestionnaire],200);
        }

        return response([],404);

    }
    public function qrlogin($qrcode){
        $gestionnaire = Gestionnaire::where('QRcode',$qrcode)->first();
        if(!$gestionnaire){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $gestionnaire,
            'token'=> $gestionnaire->createToken('gestionnaire_login_qr')->plainTextToken,
        ],200);
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
