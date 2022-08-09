<?php

namespace App\Http\Controllers\Auth\ClientDechet;

use Illuminate\Http\Request;
use App\Http\Controllers\Globale\BaseController as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Models\Client_dechet;
use Illuminate\Support\Facades\Hash;


class AuthClientDechetController extends BaseController{
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

}
