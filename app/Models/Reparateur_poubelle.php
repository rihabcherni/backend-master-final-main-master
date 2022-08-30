<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Resources\GestionCompte\Reparateur_poubelle as ReparateurPoubelleResource;

class Reparateur_poubelle extends Authenticatable{
    use HasApiTokens, SoftDeletes,HasFactory, Notifiable;
    protected $fillable = [
        'nom',
        'prenom',
        'CIN',
        'photo',
        'numero_telephone',
        'email',
        'mot_de_passe',
        'adresse',
        'QRcode',
    ];
    public function reparationPoubelles()
    {
        return $this->hasMany(Reparation_poubelle::class);
    }
    protected $dates=['deleted_at'];

    public static function getReparateurPoubelle(){
        $reparateurPoubelle = ReparateurPoubelleResource::collection(Reparateur_poubelle::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at','Liste_poubelles_repares','mot_de_passe'])->toArray();
        });
        return $reparateurPoubelle;
    }

    public static function getReparateurPoubelleById($id){
        $reparateurPoubelle = ReparateurPoubelleResource::collection(Reparateur_poubelle::where('id',$id)->get());
        return $reparateurPoubelle;
    }
    public static function getReparateurPoubelleByIdTrashed($id){
        $reparateurPoubelle = ReparateurPoubelleResource::collection(Reparateur_poubelle::withTrashed()->where('id',$id )->get());
        return $reparateurPoubelle;
    }
}
