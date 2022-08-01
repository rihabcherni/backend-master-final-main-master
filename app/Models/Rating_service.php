<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rating_service extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'responsable_etablissement_id',
        'services',
        'rating',
    ];
    protected $dates=['deleted_at'];

}
