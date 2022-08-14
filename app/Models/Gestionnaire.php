<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\GestionCompte\Gestionnaire as GestionnaireResource;

class Gestionnaire extends Authenticatable
{
    use HasApiTokens, SoftDeletes,HasFactory, Notifiable;

    protected $guarded=[];
    protected $fillable = [
        'nom',
        'prenom',
        'CIN',
        'photo',
        'adresse',
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
    public static function getGestionnaire(){
        $Gestionnaire = GestionnaireResource::collection(Gestionnaire::all());
        return $Gestionnaire;
    }

    public static function getGestionnaireById($id){
        $Gestionnaire = GestionnaireResource::collection(Gestionnaire::where('id',$id)->get());
        return $Gestionnaire;
    }
}
