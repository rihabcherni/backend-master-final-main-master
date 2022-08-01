<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock_poubelle extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'type_poubelle',
        'quantite_disponible',
        'prix_unitaire',
        'pourcentage_remise',
        'photo',
    ];
    public function blocPoubelle()
    {
        return $this->belongsTo(Bloc_poubelle::class);
    }

    public function rating_poubelle()
    {
        return $this->hasOne(Rating_poubelle::class);
    }
}
