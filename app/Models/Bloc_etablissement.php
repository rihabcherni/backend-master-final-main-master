<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloc_etablissement extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'etablissement_id',
        'nom_bloc_etablissement',
    ];
    public function etage_etablissements() {
        return $this->hasMany(Etage_etablissement::class);
    }

    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }
    protected $dates=['deleted_at'];
}
