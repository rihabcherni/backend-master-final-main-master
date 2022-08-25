<?php
namespace App\Http\Controllers\Authentification;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Globale\Controller;
use App\Models\Client_dechet;
use App\Models\Gestionnaire;
use App\Models\Ouvrier;
use App\Models\Responsable_commercial;
use App\Models\Responsable_etablissement;
use App\Models\Responsable_personnel ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class ForgotController extends Controller{
    public function forgotPassword(){

    }
}
