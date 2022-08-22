<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\GestionCompte\Responsable_personnel as ResponsablePersonnelResource;

class Responsable_personnel extends Authenticatable{
    use HasFactory, SoftDeletes, Notifiable , HasApiTokens;
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
    protected $casts =['email_verified_at' => 'datetime',];

    public static function getResponsablePersonnel(){
        $responsable_personnel = ResponsablePersonnelResource::collection(Responsable_personnel::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at','mot_de_passe','qrcode','QRcode', 'email_verified_at'])->toArray();
        });
        return $responsable_personnel;
    }

    public static function getResponsablePersonnelById($id){
        $responsable_personnel = ResponsablePersonnelResource::collection(Responsable_personnel::where('id',$id)->get());
        return $responsable_personnel;
    }
    public static function getResponsablePersonnelByIdTrashed($id){
        $responsable_personnel = ResponsablePersonnelResource::collection(Responsable_personnel::withTrashed()->where('id',$id )->get());
        return $responsable_personnel;
    }
}
