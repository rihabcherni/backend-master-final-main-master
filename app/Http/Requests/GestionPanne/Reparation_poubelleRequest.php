<?php

namespace App\Http\Requests\GestionPanne;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Reparation_poubelleRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'poubelle_id' => 'required',
                'reparateur_poubelle_id' =>'required',
                'image_panne_poubelle' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'description_panne' =>'required|string',
                'cout' =>'required',
                'date_debut_reparation'=>'required|date_format:Y-m-d',
                'date_fin_reparation'=>'required|date_format:Y-m-d',

            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'poubelle_id' => 'required',
                // 'reparateur_poubelle_id' =>'required',
                // 'image_panne_poubelle' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                // 'description_panne' =>'required|string',
                // 'cout' =>'required',
                // 'date_debut_reparation'=>'required|date_format:Y-m-d',
                // 'date_fin_reparation'=>'required|date_format:Y-m-d',
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
