<?php

namespace App\Models;

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
}

