<?php

namespace App\Http\Requests\GestionCompte;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class Client_dechetRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'nom_entreprise' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'matricule_fiscale' => 'required|string|regex:/^[A-Za-z0-9 ]*$/i|unique:client_dechets',
                'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'numero_fixe' => 'required|nullable|numeric|unique:client_dechets',
                'numero_telephone'=> 'required|string|unique:client_dechets',
                'email' => 'required|email|max:50|unique:client_dechets',
                'adresse' => 'required|string'
            ];
        }else if($this->isMethod('PUT')){
             return [
                'nom_entreprise' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'matricule_fiscale' => 'sometimes|string|regex:/^[A-Za-z0-9 ]*$/i',
                'nom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'numero_fixe' => 'sometimes|nullable|numeric',
                'numero_telephone'=> 'sometimes|string',
                'email' => 'sometimes|email|max:50',
                'adresse' => 'sometimes|string',
         ];
        }

    }
    public function failedValidation(Validator $validator){
        throw new HttpResponseException(response()->json([
                'success'   => false,
                'message'   => 'Validation errors',
                'validation_error'      => $validator->errors()
            ]));
    }
}
