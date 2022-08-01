<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Etage_etablissement extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'bloc_etablissement_id',
        'nom_etage_etablissement',
    ];
    public function bloc_poubelles() {
        return $this->hasMany(Bloc_poubelle::class);
    }

    public function bloc_etablissement(){
        return $this->belongsTo(Bloc_etablissement::class);
    }
    protected $dates=['deleted_at'];
}
