<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class PoubelleRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'bloc_poubelle_id' =>'required',
                'nom' =>'required|string',
                'type'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
                'Etat'=> 'required|between:0,100',
            ];
        }else if($this->isMethod('PUT')){
            return [
                'bloc_poubelle_id' =>'sometimes',
                'nom' =>'sometimes|string',
                'type'=>'sometimes',Rule::in(['composte', 'plastique','papier','canette']),
                'Etat'=> 'sometimes|between:0,100',
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
