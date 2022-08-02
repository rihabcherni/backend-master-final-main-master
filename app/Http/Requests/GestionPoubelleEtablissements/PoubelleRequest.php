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
                'nom_etablissement'=>'required',
                'nom_bloc_etablissement'=>'required',
                'nom_etage_etablissement'=>'required',
                'bloc_poubelle_id' =>'required',
                'type'=>'required',Rule::in(['composte', 'plastique','papier','canette']),
                'Etat'=> 'required|between:0,100',
            ];
        }else if($this->isMethod('PUT')){
            return [
                'nom_etablissement'=>'sometimes',
                'nom_bloc_etablissement'=>'sometimes',
                'nom_etage_etablissement'=>'sometimes',
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
