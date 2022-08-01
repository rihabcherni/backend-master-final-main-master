<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reparation_poubelle extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'poubelle_id',
        'reparateur_poubelle_id',
        'image_panne_poubelle',
        'description_panne',
        'cout',
        'date_debut_reparation',
        'date_fin_reparation',
    ];
    public function reparationPoubelle()
    {
        return $this->belongsTo(Reparation_poubelle::class);
    }
    public function poubelle()
    {
        return $this->hasOne(Poubelle::class);
    }
    protected $dates=['deleted_at'];

}
