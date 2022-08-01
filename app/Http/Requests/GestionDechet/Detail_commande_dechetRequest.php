<?php
namespace App\Http\Requests\GestionDechet;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
class Detail_commande_dechetRequest extends FormRequest
{
    public function authorize() {
        return true;
    }
    public function rules()  {
        if ($this->isMethod('post')) {
            return [
                'commande_dechet_id'=> 'required|numeric',
                'dechet_id'=> 'required|numeric',
                'quantite'=> 'required|numeric',
            ];
        }else if($this->isMethod('PUT')){
            return [
                // 'commande_dechet_id'=> 'required|numeric',
                // 'dechet_id'=> 'required|numeric',
                // 'quantite'=> 'required|numeric',
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
