<?php

namespace App\Http\Controllers\Auth\ResponsableEtablissement;
use App\Http\Controllers\Globale\BaseController as BaseController;
use App\Models\Responsable_etablissement;
use Illuminate\Support\Facades\File;

class AuthResponsableEtablissementController extends BaseController{
    public function allResponsableEtablissement(){
        $responsable = Responsable_etablissement::all();
        return response([
            'responsable_etablissements' => $responsable
        ]);
    }
    public function sendImage(){
        $responsable=auth()->guard('responsable_etablissement')->user();

        if($responsable !=null){
            if($responsable->photo!=null){
                $destination = 'storage/images/responsable_etablissemet'.$responsable->photo;
                return response([
                    "url"=>$destination
                ],200);
            }
            return response([
                "photo"=>null
            ],200);
        }
        return response([
            'msg' =>"undefiened responsable"
        ],401);
    }
    public function destroyImage(){
        $responsable=auth()->guard('responsable_etablissement')->user();
        if($responsable !=null){
            $destination = 'storage/images/responsable_etablissement/'.$responsable->photo;
                if(File::exists($destination)){
                    File::delete($destination);
                    $responsable->photo = null;
                    $responsable->save();
                }
                return response([
                    'status' => 200,
                    'client_dechet' =>$responsable,
                ]);
        }
    }
}
