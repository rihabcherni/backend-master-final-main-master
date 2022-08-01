<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Reparation_camion extends Model
{
    use HasFactory ,  SoftDeletes;

    protected $fillable = [
        'camion_id',
        'mecanicien_id',
        'image_panne_camion',
        'description_panne',
        'cout',
        'date_debut_reparation',
        'date_fin_reparation',
    ];
    public function reparationPoubelle()
    {
        return $this->belongsTo(Reparation_poubelle::class);
    }
    public function camion()
    {
        return $this->hasOne(Camion::class);
    }
    protected $dates=['deleted_at'];

}
