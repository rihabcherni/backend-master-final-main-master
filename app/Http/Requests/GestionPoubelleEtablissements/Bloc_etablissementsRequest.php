<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;

use Illuminate\Foundation\Http\FormRequest;

class Bloc_etablissementsRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
            'etablissement_id'=> 'required|numeric',
            'nom_bloc_etablissement'=> 'required|string',
            ];
        }else if($this->isMethod('PUT')){
            return [
                'etablissement_id'=> 'required|numeric',
                'nom_bloc_etablissement'=> 'required|string',
               ];
        }

    }
}
