<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ContactRequest extends FormRequest{
    public function authorize() {
        return true;
    }

    public function rules(){
        if ($this->isMethod('post')) {
            return [
                'nom' =>'required',
                'prenom' =>'required',
                'email' =>'required|email',
                'numero_telephone' => 'required',
                'message' => 'required',
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

