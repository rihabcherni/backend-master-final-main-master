<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\TransportDechet\Camion as CamionResource;

class Camion extends Model{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'zone_travail_id',
        'zone_depot_id',
        'matricule',
        'QRcode',
        'heure_sortie',
        'heure_entree',
        'longitude',
        'latitude',
        'volume_maximale_camion',
        'volume_actuelle_plastique',
        'volume_actuelle_papier',
        'volume_actuelle_composte',
        'volume_actuelle_canette',
        'volume_carburant_consomme',
        'Kilometrage',
    ];

    public function zone_travail()
    {
        return $this->belongsTo(Zone_travail::class);
    }
    public function ouvrier()
    {
        return $this->belongsTo(Ouvrier::class);
    }
    public function depots()
    {
        return $this->hasMany(Depot::class);
    }
    public function zone_depots()
    {
        return $this->belongsTo(Zone_depot::class);
    }
    public function etablissements() {
        return $this->hasMany(Etablissement::class);
    }
    protected $dates=['deleted_at'];
    public static function getCamion(){
        $camion = CamionResource::collection(Camion::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $camion;
    }

    public static function getCamionById($id){
        $camion = CamionResource::collection(Camion::where('id',$id)->get());
        return $camion;
    }

}




