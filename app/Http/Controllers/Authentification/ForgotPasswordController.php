<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
use App\Models\Client_dechet;
use App\Models\Forget_password;
use Illuminate\Support\Facades\Validator;
use App\Models\Gestionnaire;
use App\Models\Mecanicien;
use App\Models\Ouvrier;
use App\Models\Reparateur_poubelle;
use App\Models\Responsable_commercial;
use App\Models\Responsable_etablissement;
use App\Models\Responsable_personnel;
use App\Models\Responsable_technique;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;

class ForgotPasswordController extends Controller{
    public function sendOublierPassword($email, $code, $user, $type){
        if($email){
            $mail_data =[
                'fromEmail'=> 'reschool2022.ecology@gmail.com',
                'fromName'=> 'ReSchool',
                'toEmail' =>$email ,
                'subject' => 'nouveau mot de passe',
                'body' => ["email"=>$email , "code"=>$code, "user"=>$user, "type"=>$type],
            ];
            Mail::send('email/Oublier-password' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName']);
                $message->to($mail_data['toEmail'])->subject($mail_data['subject']);
            });
            return  response()->json("mot_de_passe",200);
        }
        return response([],404);
    }
    public function forgotPasswordVerificationCode(Request $request){
        $input = $request->all();
        $validator= Validator::make($request->all(),[
            'email' =>['required','email'],
        ]);
        if($validator->fails()){return response()->json([
            'validation_errors' =>$validator->errors(),
            'status'=>404
        ],200);}
        $gestionnaire=Gestionnaire::where('email', '=', $input['email'])->first();
        $responsable_etab=Responsable_etablissement::where('email', '=', $input['email'])->first();
        $client_dechet=Client_dechet::where('email', '=', $input['email'])->first();
        $ouvrier=Ouvrier::where('email', '=', $input['email'])->first();
        $responsable_commerciale=Responsable_commercial::where('email', '=', $input['email'])->first();
        $responsable_personnel=Responsable_personnel::where('email', '=', $input['email'])->first();
        $mecanicien=Mecanicien::where('email', '=', $input['email'])->first();
        $reparateur_poubelle=Reparateur_poubelle::where('email', '=', $input['email'])->first();
        $responsable_technique=Responsable_technique::where('email', '=', $input['email'])->first();

        $user=null;
        if($gestionnaire!==null){
            $user=$gestionnaire;
            $type="gestionnaire";
        }else if($responsable_etab!==null){
            $user=$responsable_etab;
            $type="responsable etablissement";
        }else if($client_dechet!==null){
            $user=$client_dechet;
            $type="client dechet";
        }else if($ouvrier!==null){
            $user=$ouvrier;
            $type="ouvrier";
        }else if($responsable_commerciale!==null){
            $user=$responsable_commerciale;
            $type="responsable commerciale";
        }else if($responsable_personnel!==null){
            $user=$responsable_personnel;
            $type="responsable personnel";
        }else if($mecanicien!==null){
            $user=$mecanicien;
            $type="mecanicien";
        }else if($reparateur_poubelle!==null){
            $user=$reparateur_poubelle;
            $type="reparateur poubelle";
        }else if($responsable_technique!==null){
            $user=$responsable_technique;
            $type="responsable technique";
        }
        if($user!==null){
            $test=Forget_password::where('email', '=', $input['email'])->first();
            if($test===null){
                    $SendEmail = new ForgotPasswordController;
                    $input['date_expiration_code']=now()->addHour();
                    $input['code']= Str::random(8);
                    $input['user_type']= $type;

                    $SendEmail->sendOublierPassword( $input['email'], $input['code'], $user,$type);
                    Forget_password::create($input);
                    return response(['status' => 200,
                        'user'=>$user,
                        'type'=>$type,
                        'message'=>"Votre code de vérification a  été envoyé à cette email"
                    ],200);
            }else if($test!==null && now()->lt( $test->date_expiration_code)){
                return response(['status' => 400,
                    'message'=>"Votre code de vérification a déjà été envoyé et il n'a pas encore expiré"
                ],200);
            }else{
                $SendEmail = new ForgotPasswordController;
                $input['date_expiration_code']=now()->addHour();
                $input['code']= Str::random(8);
                $SendEmail->sendOublierPassword( $input['email'], $input['code'], $user,$type);
                $test->update($input);
                return response([
                    'status' => 200,
                    'user'=>$user,
                    'type'=>$type,
                    'message'=>"Votre code de vérification a envoyé à votre email"
                ],200);
            }
        }else{
            return response([
                'status' => 404,
                'validation_errors'=>["email"=>"Votre e-mail est introuvable"],
            ],200);
        }
    }
    public function updatePasswordOublier(Request $request){
        $input = $request->all();
        $validator= Validator::make($request->all(),[
            'code' =>['required','string'],
            'mot_de_passe' =>['required' ,'string'],
            'confirme_mot_de_passe' =>['required','same:mot_de_passe','string'],
        ]);
        if($validator->fails()){
            return response()->json([
            'validation_errors' =>$validator->errors(),
            'status'=>404
        ],200);}
        $code= Forget_password::where('code',$input['code'])->first();
        $hash_password= Hash::make($input['mot_de_passe']);
        if($code!==null){
            if(now()->lt( $code->date_expiration_code)){
                if($code->user_type ==="gestionnaire"){
                    $gestionnaire= Gestionnaire::where('email', $code->email)->first();
                    $gestionnaire->mot_de_passe =$hash_password;
                    $gestionnaire->save();
                    return response()->json([
                        'message' =>"gestionnaire, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "responsable etablissement"){
                    $responsable_etablissement= Responsable_etablissement::where('email', $code->email)->first();
                    $responsable_etablissement->mot_de_passe =$hash_password;
                    $responsable_etablissement->save();
                    return response()->json([
                        'message' =>"responsable etablissement, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "client dechet"){
                    $client= Client_dechet::where('email', $code->email)->first();
                    $client->mot_de_passe =$hash_password;
                    $client->save();
                    return response()->json([
                        'message' =>"client dechet, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "ouvrier"){
                    $ouvrier= Ouvrier::where('email', $code->email)->first();
                    $ouvrier->mot_de_passe =$hash_password;
                    $ouvrier->save();
                    return response()->json([
                        'message' =>"ouvrier, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "responsable commerciale"){
                    $responsable_commerciale= Responsable_commercial::where('email', $code->email)->first();
                    $responsable_commerciale->mot_de_passe =$hash_password;
                    $responsable_commerciale->save();
                    return response()->json([
                        'message' =>"responsable commerciale, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "responsable personnel"){
                    $responsable_presonnel= Responsable_personnel::where('email', $code->email)->first();
                    $responsable_presonnel->mot_de_passe =$hash_password;
                    $responsable_presonnel->save();
                    return response()->json([
                        'message' =>"Responsable personnel, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "responsable technique"){
                    $responsable_technique= Responsable_technique::where('email', $code->email)->first();
                    $responsable_technique->mot_de_passe =$hash_password;
                    $responsable_technique->save();
                    return response()->json([
                        'message' =>"responsable technique, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "mecanicien"){
                    $mecanicien= Mecanicien::where('email', $code->email)->first();
                    $mecanicien->mot_de_passe =$hash_password;
                    $mecanicien->save();
                    return response()->json([
                        'message' =>"Mecanicien, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }else if($code->user_type=== "reparateur poubelle"){
                    $reparateur_poubelle= Reparateur_poubelle::where('email', $code->email)->first();
                    $reparateur_poubelle->mot_de_passe =$hash_password;
                    $reparateur_poubelle->save();
                    return response()->json([
                        'message' =>"Reparateur poubelle, votre mot de passe a été modifié avec succès. Essayez de vous connecter avec ce nouveau mot de passe. Si vous avez un problème, n'hésitez pas à nous contacter",
                        'status'=>200
                    ],200);
                }
            }else{
                return response([
                    'status' => 404,
                    'validation_errors'=>["code"=>"Votre code est expiré"],
                ],200);
            }
        }else{
            return response([
                'status' => 404,
                'validation_errors'=>["code"=>"Votre code est introuvable"],
            ],200);
        }
    }
}
