<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiau_primaire extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'fournisseur_id',
        'nom_materiel',
        'prix_unitaire',
        'quantite',
        'prix_total',
    ];
    public function fournisser()
    {
        return $this->belongsTo(Fournisser::class);
    }
    protected $dates=['deleted_at'];

}
