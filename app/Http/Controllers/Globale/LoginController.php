<?php
namespace App\Http\Controllers\Globale;
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
use Illuminate\Support\Facades\File;
class LoginController extends Controller{
    public function login(Request $request){
        if($request->device_name===null){$request->device_name="web";}
        $validator= Validator::make($request->all(),[
            'email' =>['required','email'],
            'mot_de_passe'=>['required', 'string'],
        ]);
        if($validator->fails()){return response()->json(['validation_errors' =>$validator->errors()],401);}
        $gestionnaire=Gestionnaire::where('email',$request->email)->first();
        $responsable_etab=Responsable_etablissement::where('email',$request->email)->first();
        $client_dechet=Client_dechet::where('email',$request->email)->first();
        $ouvrier=Ouvrier::where('email',$request->email)->first();
        $responsable_commerciale=Responsable_commercial::where('email',$request->email)->first();
        $responsable_personnel=Responsable_personnel::where('email',$request->email)->first();

        if ($gestionnaire !== null) {
            if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe,  $gestionnaire->mot_de_passe)) ){
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
            if(Auth::guard('responsable_etablissement') && (Hash::check($request->mot_de_passe,  $responsable_etab->mot_de_passe)) ){
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
            if(Auth::guard('client_dechet') && (Hash::check($request->mot_de_passe,  $client_dechet->mot_de_passe)) ){
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
            if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe,  $ouvrier->mot_de_passe)) ){
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
            if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe,  $responsable_personnel->mot_de_passe)) ){
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
            if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe,$responsable_commerciale->mot_de_passe)) ){
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
    public function logout(){
        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $client_dechet=auth()->guard('client_dechet')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();
        if($gestionnaire !=null){
            $gestionnaire->tokens()->where('id', $gestionnaire->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'gestionnaire vous avez logout avec success',
            ]);
        }else if($responsable_etab !=null){
            $responsable_etab->tokens()->where('id', $responsable_etab->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable etablissement vous avez logout avec success',
            ]);
        }else if($ouvrier !=null){
            $ouvrier->tokens()->where('id', $ouvrier->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'ouvrier vous avez logout avec success',
            ]);
        }else if($client_dechet !=null){
            $client_dechet->tokens()->where('id', $client_dechet->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'client dechet vous avez logout avec success',
            ]);
        }else if($responsable_commerciale !=null){
            $responsable_commerciale->tokens()->where('id', $responsable_commerciale->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable commerciale vous avez logout avec success',
            ]);
        }else if($responsable_personnel !=null){
            $responsable_personnel->tokens()->where('id', $responsable_personnel->currentAccessToken()->id)->delete();
            return response([
                'status' => 200,
                'message' =>'responsable personnel vous avez logout avec success',
            ]);
        }
    }
    public function modifierProfile(Request $request){
        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $client_dechet=auth()->guard('client_dechet')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();
        if($gestionnaire !=null){
            $gestionnaire->update($request->all());
            return response([
                'user' => $gestionnaire,
                'message'=> "profile mise à jour "
            ]);
        }else if($responsable_etab !=null){
            $responsable_etab->update($request->all());
            return response([
                'user' => $responsable_etab,
                'message'=> "profile mise à jour "
            ]);
        }else if($ouvrier !=null){
            $ouvrier->update($request->all());
            return response([
                'user' => $ouvrier,
                'message'=> "profile mise à jour "
            ]);
        }else if($client_dechet !=null){
            $client_dechet->update($request->all());
            return response([
                'user' => $client_dechet,
                'message'=> "profile mise à jour "
            ]);
        }else if($responsable_commerciale !=null){
            $responsable_commerciale->update($request->all());
            return response([
                'user' => $responsable_commerciale,
                'message'=> "profile mise à jour "
            ]);
        }else if($responsable_personnel !=null){
            $responsable_personnel->update($request->all());
            return response([
                'user' => $responsable_personnel,
                'message'=> "profile mise à jour "
            ]);
        }else{
            return response([
                'message' => 'undefenied user',
            ],401);
        }
    }
    public function image(Request $request, $user, $fileName) {
        $request->validate([
            'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        if($user !=null){

            if($request->hasFile('photo')){
                $image = $request->file('photo');
                $destinationPath = 'storage/images/'.$fileName;
                $destination = 'storage/images/'.$fileName.'/'.$user->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                }
                $profileImage = date('YmdHis') . "." . $image->getClientOriginalExtension();
                $image->move($destinationPath, $profileImage);
                $input['photo'] = $profileImage;
                $user['photo'] =$input['photo'];
                $user->save();
                return response([
                    'status' => 200,
                    'user' =>$user,
                ]);
            }
            return response([
                'status' => 404,
                'photo' =>'error',
            ],404);
        }
    }
    public function updatePhoto(Request $request){
        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($gestionnaire !=null){
            return (new LoginController)->image($request ,$gestionnaire,"gestionnaire");
        }else if($responsable_etab !=null){
           return (new LoginController)->image($request ,$responsable_etab, "responsable_etablissement");
        }else if($ouvrier !=null){
           return (new LoginController)->image($request ,$ouvrier, "ouvrier");
        }else if($responsable_commerciale !=null){
           return (new LoginController)->image($request ,$responsable_commerciale, 'responsable_commercial');
        }else if($responsable_personnel !=null){
           return (new LoginController)->image($request ,$responsable_personnel, "responsable_personnel");
        }else{
            return response([
                'status' => 404,
                'photo' =>'error',
            ],404);
        }

    }
    public function profile(){
        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $client_dechet=auth()->guard('client_dechet')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();

        if($gestionnaire !=null){
            return $gestionnaire;
        }else if($responsable_etab !=null){
           return $responsable_etab;
        }else if($client_dechet !=null){
           return $client_dechet;
        }else if($ouvrier !=null){
           return $ouvrier;
        }else if($responsable_commerciale !=null){
           return $responsable_commerciale;
        }else if($responsable_personnel !=null){
           return $responsable_personnel;
        }else{
            return response([
                'status' => 404,
                'photo' =>'error',
            ],404);
        }

    }
}

