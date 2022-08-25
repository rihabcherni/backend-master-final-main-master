<?php

namespace App\Http\Controllers\Auth\ClientDechet;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Client_dechet;

class AuthClientDechetController extends BaseController{
    public function allClientDechets(){
        $client = Client_dechet::all();
        return response([
            'client_dechets' => $client
        ]);
    }
}
