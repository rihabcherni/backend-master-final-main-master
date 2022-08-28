<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
use Illuminate\Support\Facades\Mail;
class SendFirstPasswordController extends Controller{
    public function sendFirstPassword($email, $nom, $prenom, $pass){
        if($email){
            $mail_data =[
                'fromEmail'=> 'reschool2022.ecology@gmail.com',
                'fromName'=> 'ReSchool',
                'toEmail' =>$email ,
                'toName' => $nom,
                'subject' => 'nouveau mot de passe',
                'body' => ["password"=>$pass, "prenom"=>$prenom,"email"=>$email, "nom"=>$nom ],
            ];
            Mail::send('email/first-password' ,$mail_data , function($message) use ($mail_data){
                $message->from($mail_data['fromEmail'], $mail_data['fromName']);
                $message->to($mail_data['toEmail'], $mail_data['toName'] )->subject($mail_data['subject']);
            });
            return  response()->json(["mot_de_passe"=>$pass],200);
        }
        return response([],404);
    }
}
