<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Forget_password extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'email',
        'user_type',
        'code',
        'date_expiration_code',
    ];

    protected $dates=['deleted_at'];
}
