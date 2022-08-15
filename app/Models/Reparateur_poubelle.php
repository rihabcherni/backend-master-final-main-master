<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionPanne\Reparateur_poubelle as ReparateurPoubelleResource;

class Reparateur_poubelle extends Model
{
    use HasFactory ,  SoftDeletes;

    protected $fillable = [
        'nom',
        'prenom',
        'CIN',
        'photo',
        'numero_telephone',
        'email',
        'mot_de_passe',
        'adresse',
        'QRcode',
    ];
    public function reparationPoubelles()
    {
        return $this->hasMany(Reparation_poubelle::class);
    }
    protected $dates=['deleted_at'];

    public static function getReparateurPoubelle(){ 
        $reparateurPoubelle = ReparateurPoubelleResource::collection(Reparateur_poubelle::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $reparateurPoubelle;
    }

    public static function getReparateurPoubelleById($id){
        $reparateurPoubelle = ReparateurPoubelleResource::collection(Reparateur_poubelle::where('id',$id)->get());
        return $reparateurPoubelle;
    }
}
