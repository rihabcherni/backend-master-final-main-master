<?php

namespace App\Http\Requests\GestionDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class DechetRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'type_dechet' => 'required',
                'pourcentage_remise' => 'required|numeric',
                'prix_unitaire' =>'required|between:0,99999999.99',
                'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'type_dechet' => 'required',
                // 'pourcentage_remise' => 'required|numeric',
                // 'prix_unitaire' =>'required|between:0,99999999.99',
                // 'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
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
