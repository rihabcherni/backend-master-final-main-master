<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating_poubelle extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'responsable_etablissement_id',
        'stock_poubelle_id',
        'rating',
    ];

    public function dechet()
    {
        return $this->belongsTo(Stock_poubelle::class);
    }
    protected $dates=['deleted_at'];

}
