<?php

namespace App\Http\Requests\GestionPoubelleEtablissements;

use Illuminate\Foundation\Http\FormRequest;

class Etage_etablissementsRequest extends FormRequest{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        if ($this->isMethod('post')) {
            return [
            'bloc_etablissement_id'=> 'required|numeric',
            'nom_etage_etablissement'=> 'required|string',
            ];
        }else if($this->isMethod('PUT')){
            return [
                'bloc_etablissement_id'=> 'required|numeric',
                'nom_etage_etablissement'=> 'required|string',
               ];
        }
    }
}
