<?php

namespace App\Http\Requests\TransportDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class DepotRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        if ($this->isMethod('post')) {
            return [
                'zone_depot_id' =>'required',
                'dechet_id' =>'required',
                'camion_id' =>'required',
                'date_depot' => translatedFormat('H:i:s j F Y H'),
                'quantite_depose_plastique' => 'required|between:0,99999',
                'quantite_depose_papier' => 'required|between:0,99999',
                'quantite_depose_composte' => 'required|between:0,99999',
                'quantite_depose_canette' => 'required|between:0,99999',
            ];
        }else if($this->isMethod('PUT')){
            return [
            //     'zone_depot_id' =>'required',
            //     'dechet_id' =>'required',
            //     'camion_id' =>'required',
            //     'date_depot' => translatedFormat('H:i:s j F Y H'),
            // 'quantite_depose_plastique' => 'required|between:0,99999',
            // 'quantite_depose_papier' => 'required|between:0,99999',
            // 'quantite_depose_composte' => 'required|between:0,99999',
            // 'quantite_depose_canette' => 'required|between:0,99999',
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
