<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\TransportDechet\Zone_depot as ZoneDepotResource;

class Zone_depot extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'zone_travail_id',
        'adresse',
        'longitude',
        'latitude',
        'quantite_depot_maximale',
        'quantite_depot_actuelle_plastique',
        'quantite_depot_actuelle_papier',
        'quantite_depot_actuelle_composte',
        'quantite_depot_actuelle_canette',
    ];
    public function depots()
    {
        return $this->hasMany(Depot::class);
    }
    public function camions()
    {
        return $this->hasMany(Camion::class);
    }
    protected $dates=['deleted_at'];
    public static function getZoneDepot(){ 
        $zone_depot = ZoneDepotResource::collection(Zone_depot::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $zone_depot;
    }

    public static function getZoneDepotById($id){
        $zone_depot = ZoneDepotResource::collection(Zone_depot::where('id',$id)->get());
        return $zone_depot;
    }
}
