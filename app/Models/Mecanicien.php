<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionPanne\Mecanicien as MecanicienResource;

class Mecanicien extends Model
{
    use HasFactory,  SoftDeletes;
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
    public function reparationCamions()
    {
        return $this->hasMany(Reparation_camion::class);
    }
    protected $dates=['deleted_at'];

    public static function getMecanicien(){
        $mecanicien = MecanicienResource::collection(Mecanicien::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at','mot_de_passe','Liste_camions_repares'])->toArray();
        });
        return $mecanicien;
    }

    public static function getMecanicienById($id){
        $mecanicien = MecanicienResource::collection(Mecanicien::where('id',$id)->get());
        return $mecanicien;
    }
    public static function getMecanicienByIdTrashed($id){
        $mecanicien = MecanicienResource::collection(Mecanicien::withTrashed()->where('id',$id )->get());
        return $mecanicien;
    }
}
