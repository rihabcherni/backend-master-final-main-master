<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionPoubelleEtablissements\Zone_travail as ZoneTravailResource;

class Zone_travail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'region',
        'quantite_total_collecte_plastique',
        'quantite_total_collecte_composte',
        'quantite_total_collecte_papier',
        'quantite_total_collecte_canette',
    ];

    public function camions()
    {
        return $this->hasMany(Camion::class);
    }

    public function etablissements()
    {
        return $this->hasMany(Etablissement::class);
    }
    protected $dates=['deleted_at'];
    public static function getZoneTravail(){
        $zoneTravail = ZoneTravailResource::collection(Zone_travail::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $zoneTravail;
    }
    public static function getZoneTravailById($id){
        $zoneTravail = ZoneTravailResource::collection(Zone_travail::where('id',$id)->get());
        return $zoneTravail;
    }
    public static function getZoneTravailByIdTrashed($id){
        $zoneTravail = ZoneTravailResource::collection(Zone_travail::withTrashed()->where('id',$id )->get());
        return $zoneTravail;
    }
}
