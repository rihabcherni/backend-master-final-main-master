<?php

namespace App\Http\Requests\GestionCompte;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class ResponsableCommercialeRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'nom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'required|string|regex:/^[A-Za-z ]*$/i',
                'CIN'=>'required|numeric',
                'numero_telephone'=> 'required|string',
                'email' => 'required|email|max:50',
                'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            ];
         }else if($this->isMethod('PUT')){
             return [
                'nom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'prenom' => 'sometimes|string|regex:/^[A-Za-z ]*$/i',
                'CIN'=>'sometimes|numeric',
                'numero_telephone'=> 'sometimes|string',
                'email' => 'sometimes|email|max:50',
                'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
