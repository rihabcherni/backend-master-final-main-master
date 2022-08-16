<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\TransportDechet\Depot as DepotResource;

class Depot extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'zone_depot_id',
        'camion_id',
        'date_depot',
        'quantite_depose_plastique',
        'quantite_depose_papier',
        'quantite_depose_composte',
        'quantite_depose_canette',
    ];

    public function zone_depot()
    {
        return $this->belongsTo(Zone_depot::class);
    }

    public function camion()
    {
        return $this->belongsTo(Camion::class);
    }
    protected $dates=['deleted_at'];

    public static function getDepot(){
        $depot = DepotResource::collection(Depot::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at','zone_depot','camion'])->toArray();
        });
        return $depot;
    }

    public static function getDepotById($id){
        $depot = DepotResource::collection(Depot::where('id',$id)->get());
        return $depot;
    }
}
