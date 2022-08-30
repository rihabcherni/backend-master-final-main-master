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
                'quantite_plastique'=> 'sometimes|numeric',
                'quantite_papier'=> 'sometimes|numeric',
                'quantite_composte'=> 'sometimes|numeric',
                'quantite_canette'=> 'sometimes|numeric',
                'prix_plastique'=> 'sometimes|numeric',
                'prix_papier'=> 'sometimes|numeric',
                'prix_composte'=> 'sometimes|numeric',
                'prix_canette'=> 'sometimes|numeric',
                'type_paiment'=> 'sometimes|numeric',
                'montant_total'=> 'sometimes|numeric',
                'date_commande'=> 'sometimes|date_format:Y-m-d',
                'date_livraison'=> 'sometimes|date_format:Y-m-d',


            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'client_dechet_id'=> 'required|numeric',
                // 'quantite_plastique'=> 'sometimes|numeric',
                // 'quantite_papier'=> 'sometimes|numeric',
                // 'quantite_composte'=> 'sometimes|numeric',
                // 'quantite_canette'=> 'sometimes|numeric',
                // 'prix_plastique'=> 'sometimes|numeric',
                // 'prix_papier'=> 'sometimes|numeric',
                // 'prix_composte'=> 'sometimes|numeric',
                // 'prix_canette'=> 'sometimes|numeric',
                // 'type_paiment'=> 'sometimes|numeric',
                // 'montant_total'=> 'sometimes|numeric',
                // 'date_commande'=> 'sometimes|date_format:Y-m-d',
                // 'date_livraison'=> 'sometimes|date_format:Y-m-d',
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
