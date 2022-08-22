<?php

namespace App\Models;

use App\Http\Resources\ViderPoubelle;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vider_poubelle extends Model
{
    use HasFactory;
    protected $fillable = [
        'poubelle_id',
        'camion_id',
        'date_depot',
        'etat',
        'quantite_depose_plastique',
        'quantite_depose_papier',
        'quantite_depose_composte',
        'quantite_depose_canette',
        'type_poubelle'
    ];

    public static function getViderPoubelle(){
        $viderPoubelle = ViderPoubelle::collection(Vider_poubelle::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $viderPoubelle;
    }

    public static function getViderPoubelleById($id){
        $viderPoubelle = ViderPoubelle::collection(Vider_poubelle::where('id',$id)->get());
        return $viderPoubelle;
    }
}


