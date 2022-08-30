<?php
namespace App\Http\Controllers\Authentification;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Globale\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class ModifierPasswordController extends Controller{
    public function modifierPassword (Request $request ){
        $validator= Validator::make($request->all(),['nouveau_mot_de_passe' =>['required','string'],'mot_de_passe'=>['required', 'string'] ]);
        if($validator->fails()){ return response()->json(['validation_errors' =>$validator->errors(),'status'=>401],200); }

        $gestionnaire=auth()->guard('gestionnaire')->user();
        $responsable_etab=auth()->guard('responsable_etablissement')->user();
        $client_dechet=auth()->guard('client_dechet')->user();
        $ouvrier=auth()->guard('ouvrier')->user();
        $responsable_commerciale=auth()->guard('responsable_commercial')->user();
        $responsable_personnel=auth()->guard('responsable_personnel')->user();
        $responsable_technique=auth()->guard('responsable_technique')->user();
        $mecanicien=auth()->guard('mecanicien')->user();
        $reparateur_poubelle=auth()->guard('reparateur_poubelle')->user();
        if($gestionnaire !=null){
            if(Auth::guard('gestionnaire') && (Hash::check($request->mot_de_passe, $gestionnaire->mot_de_passe)) ){
                $gestionnaire['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $gestionnaire->save();
                return response(['message'=>'gestionnaire votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401],200);
        }else if($responsable_etab !=null){
            if(Auth::guard('responsable_etablissement') && (Hash::check($request->mot_de_passe, $responsable_etab->mot_de_passe)) ){
                $responsable_etab['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $responsable_etab->save();
                return response(['message'=>'responsable etablissement votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401],200);
        }else if($client_dechet !=null){
            if(Auth::guard('client_dechet') && (Hash::check($request->mot_de_passe, $client_dechet->mot_de_passe)) ){
                $client_dechet['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $client_dechet->save();
                return response(['message'=>'client dechet votre mot de passe est mise à jour avec success '],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($ouvrier !=null){
            if(Auth::guard('ouvrier') && (Hash::check($request->mot_de_passe, $ouvrier->mot_de_passe)) ){
                $ouvrier['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $ouvrier->save();
                return response(['message'=>'ouvrier votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($responsable_commerciale !=null){
            if(Auth::guard('responsable_commercial') && (Hash::check($request->mot_de_passe, $responsable_commerciale->mot_de_passe)) ){
                $responsable_commerciale['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $responsable_commerciale->save();
                return response([ 'message'=>'responsable commerciale votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($responsable_personnel !=null){
            if(Auth::guard('responsable_personnel') && (Hash::check($request->mot_de_passe, $responsable_personnel->mot_de_passe)) ){
                $responsable_personnel['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $responsable_personnel->save();
                return response([ 'message'=>'responsable personnel votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($responsable_technique !=null){
            if(Auth::guard('responsable_technique') && (Hash::check($request->mot_de_passe, $responsable_technique->mot_de_passe)) ){
                $responsable_technique['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $responsable_technique->save();
                return response([ 'message'=>'responsable technique votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($reparateur_poubelle !=null){
            if(Auth::guard('reparateur_poubelle') && (Hash::check($request->mot_de_passe, $reparateur_poubelle->mot_de_passe)) ){
                $reparateur_poubelle['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $reparateur_poubelle->save();
                return response([ 'message'=>'reparateur poubelle votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }else if($mecanicien !=null){
            if(Auth::guard('mecanicien') && (Hash::check($request->mot_de_passe, $mecanicien->mot_de_passe)) ){
                $mecanicien['mot_de_passe'] = Hash::make($request->nouveau_mot_de_passe);
                $mecanicien->save();
                return response(['message'=>'mecanicien votre mot de passe est mise à jour avec success ','status'=>200],200);
            }
            return response(['validation_errors' =>["mot_de_passe"=>'votre ancien mot de passe est incorrect'],'status'=>401 ],200);
        }
        return response(['message' => "vous n'avez pas connecté",'status'=>401],200);
    }
}
