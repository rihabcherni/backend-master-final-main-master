<?php

namespace App\Http\Requests\TransportDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class CamionRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        if ($this->isMethod('post')) {
            return [
                'zone_travail_id' => 'required',
                'zone_depot_id' =>'sometimes',
                'matricule'=> 'required',
                'heure_sortie' => 'sometimes|date_format:"Y-m-d H:i:s"',
                'heure_entree' => 'sometimes|date_format:"Y-m-d H:i:s"',
                'longitude' => 'sometimes',
                'latitude' => 'sometimes',
                'volume_maximale_camion' => 'sometimes|between:0,99999999999',
                'volume_actuelle_plastique' =>'sometimes|between:0,99999999999',
                'volume_actuelle_papier' => 'sometimes|between:0,99999999999',
                'volume_actuelle_composte' =>'sometimes|between:0,99999999999',
                'volume_actuelle_canette' => 'sometimes|between:0,99999999999',
                'volume_carburant_consomme' =>'sometimes|between:0,99999999999',
                'Kilometrage' =>'sometimes|between:0,99999999999',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'zone_travail_id' => 'required',
                // 'zone_depot_id' =>'sometimes',
                // 'matricule'=> 'required',
                // 'heure_sortie' => 'sometimes|date_format:"Y-m-d H:i:s"',
                // 'heure_entree' => 'sometimes|date_format:"Y-m-d H:i:s"',
                // 'longitude' => 'sometimes',
                // 'latitude' => 'sometimes',
                // 'volume_maximale_camion' => 'sometimes|between:0,99999999999',
                // 'volume_actuelle_plastique' =>'sometimes|between:0,99999999999',
                // 'volume_actuelle_papier' => 'sometimes|between:0,99999999999',
                // 'volume_actuelle_composte' =>'sometimes|between:0,99999999999',
                // 'volume_actuelle_canette' => 'sometimes|between:0,99999999999',
                // 'volume_carburant_consomme' =>'sometimes|between:0,99999999999',
                // 'Kilometrage' =>'sometimes|between:0,99999999999',
           ];
        }

    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'validation_error' => $validator->errors()
            ]));
    }
}
