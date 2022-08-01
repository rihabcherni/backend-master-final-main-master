<?php

namespace App\Http\Resources;
use App\Http\Resources\GestionCompte\Client_dechet as Client_dechet_RCE;
use App\Http\Resources\GestionCompte\Ouvrier as Ouvrier_RCE;
use App\Http\Resources\GestionCompte\Responsable_commercial as Responsable_commercial_RCE;
use App\Http\Resources\GestionCompte\Responsable_personnel as Responsable_personnel_RCE;
use App\Models\Client_dechet;
use App\Models\Ouvrier;
use App\Models\Responsable_personnel;
use App\Models\Responsable_commercial;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Http\Resources\MessageResource;
class ConversationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data['id'] = $this->id;
        if($this->auth_second_user=='client_dechet'){
            $data['user'] = new Client_dechet_RCE(Client_dechet::find($this->second_user_id)) ;
        }
        if($this->auth_second_user=='ouvrier'){
            $data['user'] = new Ouvrier_RCE(Ouvrier::find($this->second_user_id )) ;
        }
        if($this->auth_second_user=='responsable_commercial'){
            $data['user'] = new Responsable_commercial_RCE(Responsable_commercial::find($this->second_user_id )) ;
        }
        if($this->auth_second_user=='responsable_personnel'){
            $data['user'] = new Responsable_personnel_RCE(Responsable_personnel::find($this->second_user_id )) ;
        }
        $data['auth_user']=$this->auth_user ;
        $data['auth_second_user']=$this->auth_second_user;
        $data['created_at'] = Carbon::parse($this->created_at)->toDateTimeString();
        $msg= $this->messages->isEmpty()? null : MessageResource::collection($this->messages);
        if(is_null($msg)){
            $data['messages'] = null;
        }else{
            $compteur = count($msg);
            for($i = 0;$i < $compteur ; $i++){
                for ($j = $i + 1; $j < $compteur; $j++) {
                    if (isset($msg[$i]->id) && isset($msg[$j]->id) && $msg[$i]->id < $msg[$j]->id){
                        $temp = $msg[$i];
                        $msg[$i] = $msg[$j];
                        $msg[$j] = $temp;
                    }
                }
            }
            $data['messages'] = MessageResource::collection($msg);
        }
        return $data;
    }
}
