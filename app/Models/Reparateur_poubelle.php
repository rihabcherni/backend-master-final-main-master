<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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

}
