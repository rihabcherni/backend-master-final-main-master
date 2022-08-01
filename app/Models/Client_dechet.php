<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;

class Client_dechet  extends Authenticatable{
    use HasFactory, SoftDeletes, Notifiable, HasApiTokens;

    protected $guarded=[];
    protected $fillable = [
        'nom_entreprise',
        'matricule_fiscale',
        'nom',
        'prenom',
        'numero_fixe',
        'adresse',
        'numero_telephone',
        'mot_de_passe',
        'email',
        'QRcode',
    ];
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function commande_dechet()
    {
        return $this->belongsTo(Commande_dechet::class);
    }
    protected $dates=['deleted_at'];
}
