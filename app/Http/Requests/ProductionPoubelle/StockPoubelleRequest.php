<?php

namespace App\Http\Requests\ProductionPoubelle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class StockPoubelleRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules(){
        if ($this->isMethod('post')) {
            return [
                'type_poubelle'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
                'quantite_disponible'=>'required|integer',
                'pourcentage_remise'=>'required|numeric',
                'prix_unitaire'=>'required|numeric',
                'photo'=> 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'type_poubelle'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
                // 'quantite_disponible'=>'required|integer',
                // 'pourcentage_remise'=>'required|numeric',
                // 'prix_unitaire'=>'required|numeric',
                // 'photo'=> 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
