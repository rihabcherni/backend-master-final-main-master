<?php

namespace App\Http\Requests\GestionDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Commande_dechetRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'client_dechet_id'=> 'required|numeric',
                'quantite'=> 'required|numeric',
                'montant_total'=> 'required|numeric',
                'date_commande'=> 'sometimes|date_format:Y-m-d',
                'date_livraison'=> 'sometimes|date_format:Y-m-d',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'client_dechet_id'=> 'required|numeric',
                // 'quantite'=> 'required|numeric',
                // 'montant_total'=> 'required|numeric',
                // 'date_commande'=> 'required|date_format:Y-m-d',
                // 'date_livraison'=> 'required|date_format:Y-m-d',
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
