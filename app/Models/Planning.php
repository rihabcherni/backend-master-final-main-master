<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Planning extends Model
{
    use HasFactory,  SoftDeletes, Notifiable , HasApiTokens;
    protected $fillable = [
        'id',
        'jour',
        'start',
        'end',
        'validation',
        'statut',
        'date_collecte',
        'type_poubelle',
        'id_poubelle',
        'id_ouvrier',
    ];
    protected $dates=['deleted_at'];
}
