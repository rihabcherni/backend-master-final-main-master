<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating_dechet extends Model
{

    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'client_dechet_id',
        'dechet_id',
        'rating',
    ];

    public function dechet()
    {
        return $this->belongsTo(Dechet::class);
    }
    protected $dates=['deleted_at'];

}

