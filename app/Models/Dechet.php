<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dechet extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'type_dechet',
        'prix_unitaire',
        'photo',
        'pourcentage_remise'
    ];
    public function depots()
    {
        return $this->hasMany(Depot::class);
    }
    public function rating_poubelle()
    {
        return $this->hasOne(Rating_dechet::class);
    }

    protected $dates=['deleted_at'];

}
