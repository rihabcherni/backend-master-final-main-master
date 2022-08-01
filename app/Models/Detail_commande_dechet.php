<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Detail_commande_dechet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'commande_dechet_id',
        'dechet_id',
        'quantite',
    ];

    public function commande_dechet()
    {
        return $this->belongsTo(Commande_dechet::class);
    }
}
