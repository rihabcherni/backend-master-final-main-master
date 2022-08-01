<?php

namespace App\Http\Requests\TransportDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Zone_depotRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        if ($this->isMethod('post')) {
            return [
                'zone_travail_id' => 'required|integer' ,
                'adresse' => 'required|string',
                'longitude' => 'required',
                'latitude' => 'required',
                'quantite_depot_maximale' => 'required|between:0,99999999999' ,
                'quantite_depot_actuelle_plastique' => 'required|between:0,99999999999',
                'quantite_depot_actuelle_papier' => 'required|between:0,99999999999',
                'quantite_depot_actuelle_composte' => 'required|between:0,99999999999',
                'quantite_depot_actuelle_canette' => 'required|between:0,99999999999',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'zone_travail_id' => 'required|integer' ,
                // 'adresse' => 'required|string',
                // 'longitude' => 'required',
                // 'latitude' => 'required',
                // 'quantite_depot_maximale' => 'required|between:0,99999999999' ,
                // 'quantite_depot_actuelle_plastique' => 'required|between:0,99999999999',
                // 'quantite_depot_actuelle_papier' => 'required|between:0,99999999999',
                // 'quantite_depot_actuelle_composte' => 'required|between:0,99999999999',
                // 'quantite_depot_actuelle_canette' => 'required|between:0,99999999999',
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
