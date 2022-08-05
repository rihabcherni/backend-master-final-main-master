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
                'etablissement_id'=>'required',
                'bloc_etablissement_id'=>'required',
                'etage_etablissement_id'=>'required',
                'bloc_poubelle_id' =>'required',
                'type'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
            ];
        }else if($this->isMethod('PUT')){
            return [
                'etablissement_id'=>'sometimes',
                'bloc_etablissement_id'=>'sometimes',
                'etage_etablissement_id'=>'sometimes',
                'bloc_poubelle_id' =>'sometimes',
                'nom' =>'sometimes|string',
                'type'=>'sometimes',Rule::in(['composte', 'plastique','papier','canette']),
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
