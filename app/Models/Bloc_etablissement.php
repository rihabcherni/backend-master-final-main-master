<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionPoubelleEtablissements\Bloc_etablissements as BlocEtablissementResource;

class Bloc_etablissement extends Model
{
    use HasFactory,SoftDeletes;
    protected $fillable = [
        'etablissement_id',
        'nom_bloc_etablissement',
    ];
    public function etage_etablissements() {
        return $this->hasMany(Etage_etablissement::class);
    }

    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }
    protected $dates=['deleted_at'];

    public static function getBlocEtablissement(){
        $blocEtablissement = BlocEtablissementResource::collection(Bloc_etablissement::all());
        return $blocEtablissement;
    }

    public static function getBlocEtablissementById($id){
        $blocEtablissement = BlocEtablissementResource::collection(Bloc_etablissement::where('id',$id)->get());
        return $blocEtablissement;
    }
}
