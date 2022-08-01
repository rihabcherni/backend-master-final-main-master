<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
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
}
