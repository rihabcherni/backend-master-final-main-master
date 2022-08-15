<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionPoubelleEtablissements\Etage_etablissements as EtageEtablissementResource;

class Etage_etablissement extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'bloc_etablissement_id',
        'nom_etage_etablissement',
    ];
    public function bloc_poubelles() {
        return $this->hasMany(Bloc_poubelle::class);
    }

    public function bloc_etablissement(){
        return $this->belongsTo(Bloc_etablissement::class);
    }
    protected $dates=['deleted_at'];
    public static function getEtageEtablissement(){ 
        $etageEtablissement = EtageEtablissementResource::collection(Etage_etablissement::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $etageEtablissement;
    }

    public static function getEtageEtablissementById($id){
        $etageEtablissement = EtageEtablissementResource::collection(Etage_etablissement::where('id',$id)->get());
        return $etageEtablissement;
    }
}
