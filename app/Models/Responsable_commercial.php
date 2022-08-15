<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\GestionCompte\Responsable_commercial as ResponsableCommercialResource;

class Responsable_commercial  extends Authenticatable{
    use HasApiTokens, SoftDeletes,HasFactory, Notifiable;

    protected $guarded=[];
    protected $fillable = [
        'nom',
        'prenom',
        'CIN',
        'photo',
        'numero_telephone',
        'email',
        'mot_de_passe',
        'QRcode',
    ];
    protected $hidden = [
        'mot_de_passe',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getResponsableCommercial(){
        $responsableCommercial = ResponsableCommercialResource::collection(Responsable_commercial::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at','mot_de_passe','qrcode','QRcode', 'email_verified_at'])->toArray();
        });
        return $responsableCommercial;
    }

    public static function getResponsableCommercialeById($id){
        $responsableCommercial = ResponsableCommercialResource::collection(Responsable_commercial::where('id',$id)->get());
        return $responsableCommercial;
    }
}
