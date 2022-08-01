<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bloc_poubelle extends Model{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'etage_etablissement_id',
    ];
    public function poubelles() {
        return $this->hasMany(Poubelle::class);
    }

    public function etage_etablissement(){
        return $this->belongsTo(Etage_etablissement::class);
    }
    protected $dates=['deleted_at'];
}



