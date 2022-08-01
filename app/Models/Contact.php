<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numero_telephone',
        'message'
        ];
    protected $dates=['deleted_at'];
}
