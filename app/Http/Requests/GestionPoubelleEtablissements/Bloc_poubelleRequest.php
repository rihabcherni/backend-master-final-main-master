<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Bloc_poubelleRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'etablissement_id' => 'required',
                'nom_bloc_etablissement' =>'required',
            ];
        }else if($this->isMethod('PUT')){
            return [
            //     'etablissement_id' => 'required',
            // 'bloc_etablissement' =>'required|required',
            // 'etage_etablissement' =>'required|required',
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
