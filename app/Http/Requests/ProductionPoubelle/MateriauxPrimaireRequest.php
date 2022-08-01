<?php

namespace App\Http\Requests\ProductionPoubelle;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class MateriauxPrimaireRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'fournisseur_id'=> 'required',
                'nom_materiel' => 'required|string',
                'prix_unitaire' => 'required|between:0,999999',
                'quantite' => 'required|between:0,99999',
                'prix_total' =>'required|between:0,99999',
            ];
        }else if($this->isMethod('PUT')){
            return [
            //     'fournisseur_id'=> 'required',
            //     'nom_materiel' => 'required|string',
            //     'prix_unitaire' 'required|between:0,99999999999',
            //     'quantite' => 'required|between:0,99999999999',
            //     'prix_total' =>'required|between:0,99999999999',
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
