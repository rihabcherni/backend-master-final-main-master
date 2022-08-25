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
class LoginController extends Controller{
    public function login(Request $request){
        if($request->device_name===null){$request->device_name="web";}
        $validator= Validator::make($request->all(),[
            'email' =>['required','email'],
            'mot_de_passe'=>['required', 'string'],
            'recaptcha'=>['required', 'string'],
        ]);
        if($validator->fails()){return response()->json(['validation_errors' =>$validator->errors(),'status'=>401],200);}
        $gestionnaire=Gestionnaire::where('email',$request->email)->first();
        $responsable_etab=Responsable_etablissement::where('email',$request->email)->first();
        $client_dechet=Client_dechet::where('email',$request->email)->first();
        $ouvrier=Ouvrier::where('email',$request->email)->first();
        $responsable_commerciale=Responsable_commercial::where('email',$request->email)->first();
        $responsable_personnel=Responsable_personnel::where('email',$request->email)->first();

        if ($gestionnaire !== null) {
            if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe,  $gestionnaire->mot_de_passe))  && ($request->recaptcha!== null) ){
                return response()->json([
                    'Role'=>'gestionnaire',
                    'device_name'=>$request->device_name,
                    'status'=>200,
                    'user'=>$gestionnaire,
                    'token'=> $gestionnaire->createToken('gestionnaire-login')->plainTextToken,
                    'message' =>'gestionnaire vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else if ($responsable_etab !== null){
            if(Auth::guard('responsable_etablissement') && (Hash::check($request->mot_de_passe,  $responsable_etab->mot_de_passe))   && ($request->recaptcha!== null) ){
                return response()->json([
                    'Role'=>'responsable_etablissement',
                    'status'=>200,
                    'user'=>$responsable_etab,
                    'token'=> $responsable_etab->createToken('responsable-etablissement-login')->plainTextToken,
                    'message' =>'responsable etablissement vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else if ($client_dechet !== null){
            if(Auth::guard('client_dechet') && (Hash::check($request->mot_de_passe,  $client_dechet->mot_de_passe))   && ($request->recaptcha!== null)){
                return response()->json([
                    'Role'=>'client_dechet',
                    'status'=>200,
                    'user'=>$client_dechet,
                    'token'=> $client_dechet->createToken('client-dechet-login')->plainTextToken,
                    'message' =>'client dechet vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else if ($ouvrier !== null){
            if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe,  $ouvrier->mot_de_passe))   && ($request->recaptcha!== null)){
                return response()->json([
                    'Role'=>'ouvrier',
                    'status'=>200,
                    'user'=>$ouvrier,
                    'token'=> $ouvrier->createToken('ouvrier-login')->plainTextToken,
                    'message' =>'ouvrier vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else if ($responsable_personnel !== null){
            if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe,  $responsable_personnel->mot_de_passe))  && ($request->recaptcha!== null) ){
                return response()->json([
                    'Role'=>'responsable_personnel',
                    'status'=>200,
                    'user'=>$responsable_personnel,
                    'token'=> $responsable_personnel->createToken('responsable-personnel-login')->plainTextToken,
                    'message' =>'responsable_personnel vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else if ($responsable_commerciale !== null){
            if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe,$responsable_commerciale->mot_de_passe))  && ($request->recaptcha!== null) ){
                return response()->json([
                    'Role'=>'responsable_commerciale',
                    'status'=>200,
                    'user'=>$responsable_commerciale,
                    'token'=> $responsable_commerciale->createToken('responsable-commercial-login')->plainTextToken,
                    'message' =>'responsable_commercial vous avez connecté avec success',
                ],200);
            }else{
                return response()->json(['error' => 'Invalid credentials','validation_errors' =>["mot_de_passe"=>"votre mot de passe est incorrect. Veuillez réessayer ultérieurement."], 'status'=>401]);
            }
        }else{
            return response()->json(['error' => 'Invalid credentials','validation_errors' =>["email"=>"Le champ email saisie est invalide"], 'status'=>401]);
        }
    }
}
