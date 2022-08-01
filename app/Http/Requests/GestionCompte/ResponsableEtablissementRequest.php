<?php

namespace App\Http\Requests\GestionCompte;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ResponsableEtablissementRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'etablissement_id'=> 'sometimes|integer',
                'numero_fixe' => 'required|numeric',
                'numero_telephone'=> 'required|string',
                'mot_de_passe' => 'required|string|min:6',
                'email' => 'required|unique:responsable_etablissements,email,|email|max:50',
                'adresse' => 'required|string',
                'QRcode' => 'sometimes|string'
            ];
         }else if($this->isMethod('PUT')){
             return [
                'nom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'etablissement_id'=> 'sometimes|integer',
                'prenom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'numero_fixe' => 'sometimes|numeric',
                'numero_telephone'=> 'sometimes|string',
                'mot_de_passe' => 'sometimes|string|min:6',
                'email' => 'sometimes|email|max:50',
                'adresse' => 'sometimes|string',
                'QRcode' => 'sometimes|string'
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
