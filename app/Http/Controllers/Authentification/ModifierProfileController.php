<?php
namespace App\Http\Controllers\Authentification;
use App\Http\Controllers\Globale\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class ModifierProfileController extends Controller{
    public function modifierProfile(Request $request){
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
        }else if($responsable_technique !=null){
            $responsable_technique->update($request->all());
            return response([
                'user' => $responsable_technique,
                'message'=> "profile mise à jour "
            ]);
        }else if($mecanicien !=null){
            $mecanicien->update($request->all());
            return response([
                'user' => $mecanicien,
                'message'=> "profile mise à jour "
            ]);
        }else if($reparateur_poubelle !=null){
            $reparateur_poubelle->update($request->all());
            return response([
                'user' => $reparateur_poubelle,
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
        $responsable_technique=auth()->guard('responsable_technique')->user();
        $mecanicien=auth()->guard('mecanicien')->user();
        $reparateur_poubelle=auth()->guard('reparateur_poubelle')->user();

        if($gestionnaire !=null){
            return (new ModifierProfileController)->image($request ,$gestionnaire,"gestionnaire");
        }else if($responsable_etab !=null){
           return (new ModifierProfileController)->image($request ,$responsable_etab, "responsable_etablissement");
        }else if($ouvrier !=null){
           return (new ModifierProfileController)->image($request ,$ouvrier, "ouvrier");
        }else if($responsable_commerciale !=null){
           return (new ModifierProfileController)->image($request ,$responsable_commerciale, 'responsable_commercial');
        }else if($responsable_personnel !=null){
           return (new ModifierProfileController)->image($request ,$responsable_personnel, "responsable_personnel");
        }else if($responsable_technique !=null){
            return (new ModifierProfileController)->image($request ,$responsable_technique, "responsable_technique");
        }else if($mecanicien !=null){
            return (new ModifierProfileController)->image($request ,$mecanicien, "mecanicien");
        }else if($reparateur_poubelle !=null){
            return (new ModifierProfileController)->image($request ,$reparateur_poubelle, "reparateur_poubelle");
        }else{
            return response([
                'status' => 404,
                'photo' =>'error',
            ],404);
        }
    }
}
