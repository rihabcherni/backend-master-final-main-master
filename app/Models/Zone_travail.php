<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Zone_travail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'region',
        'quantite_total_collecte_plastique',
        'quantite_total_collecte_composte',
        'quantite_total_collecte_papier',
        'quantite_total_collecte_canette',
    ];

    public function camions()
    {
        return $this->hasMany(Camion::class);
    }

    public function etablissements()
    {
        return $this->hasMany(Etablissement::class);
    }
    protected $dates=['deleted_at'];
}
