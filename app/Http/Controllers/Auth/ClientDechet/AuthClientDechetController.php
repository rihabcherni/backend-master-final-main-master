<?php

namespace App\Http\Controllers\Auth\ClientDechet;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class AuthClientDechetController extends BaseController{
    public function qrlogin($qrcode){
        $client = Client_dechet::where('QRcode',$qrcode)->first();
        if(!$client){
            return response([
                    'message' => 'invalid qr'
            ] , 401);
        }
        return response([
            'user' => $client,
            'token'=> $client->createToken('client-dechet-login')->plainTextToken,
        ],200);
    }

    public function allClientDechets(){
        $client = Client_dechet::all();
        return response([
            'client_dechets' => $client
        ]);
    }

    public function modifierPasswordClientDechet (Request $request , $email){
        $client=Client_dechet::where('email',$email)->first();

        if(Auth::guard('client_dechet') && (Hash::check($request->mot_de_passe, $client->mot_de_passe)) ){
                $client['mot_de_passe'] = Hash::make($request->newPassword);
                $client->save();
                return response([
                    'message'=>'password updated'
                ],200);
            }

        return response([
            'message' => 'incorrect password'
        ],403);
    }
    public function sendFirstPassword(Request $request){
        $clientDechet = Client_dechet::where('email',$request->email)->first();
        if($clientDechet){
            $mail_message = 'client dechet votre mot de passe est ';
            $pass = Str::random(8);
            $mail_message .= $pass ;
            $mail_data =[
                'recipient'=> 'arijcherni001@gmail.com',
                'fromEmail' =>$clientDechet->email ,
                'fromName' => $clientDechet->name,
                'subject' => 'nouveau mot de passe',
                'body' => $mail_message,
            ];
            Mail::send('email-template' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName'] );
                $message->to($mail_data['recipient'], 'ReSchool')
                ->subject($mail_data['subject']);
            });
            $clientDechet['mot_de_passe'] = Hash::make($pass);
            $clientDechet->save();
            return response([$clientDechet],200);
        }

        return response([],404);

    }



}
