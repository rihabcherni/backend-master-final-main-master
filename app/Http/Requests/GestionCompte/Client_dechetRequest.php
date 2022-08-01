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
                'matricule_fiscale' => 'required|string|regex:/^[A-Za-z0-9 ]*$/i',
                'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'numero_fixe' => 'sometimes|nullable|numeric|unique:client_dechets',
                'numero_telephone'=> 'required|string',
                'mot_de_passe' => 'required|string|min:6',
                'email' => 'required|unique:client_dechets,email,|email|max:50',
                'adresse' => 'required|string'
            ];
        }else if($this->isMethod('PUT')){
             return [
                'nom_entreprise' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'matricule_fiscale' => 'required|string|regex:/^[A-Za-z0-9 ]*$/i',
                'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'numero_fixe' => 'sometimes|nullable|numeric',
                'numero_telephone'=> 'required|string',
                'mot_de_passe' => 'required|string|min:6',
                'email' => 'required|email|max:50',
                'adresse' => 'required|string',
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
