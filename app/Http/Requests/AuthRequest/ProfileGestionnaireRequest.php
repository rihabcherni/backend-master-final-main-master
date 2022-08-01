<?php

namespace App\Http\Requests\AuthRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ProfileGestionnaireRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
     if($this->isMethod('put')){
            return [
                'nom' => 'string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'string|regex:/^[A-Za-z ]*$/i',
                'CIN' => 'numeric',
                'adresse' => 'string',
                'numero_telephone'=> 'integer',
                'email' => 'email|max:50',
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
