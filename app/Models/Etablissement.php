<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Etablissement extends Model
{
    use HasFactory,  SoftDeletes;
    use \Staudenmeir\EloquentHasManyDeep\HasRelationships;

    protected $fillable = [
        'zone_travail_id',
        'camion_id',
        'nom_etablissement',
        'niveau_etablissement',
        'type_etablissement',
        'nbr_personnes',
        'url_map',
        'adresse',
        'longitude',
        'latitude',

        'quantite_dechets_plastique',
        'quantite_dechets_composte',
        'quantite_dechets_papier',
        'quantite_dechets_canette',

        'quantite_plastique_mensuel',
        'quantite_composte_mensuel',
        'quantite_papier_mensuel',
        'quantite_canette_mensuel'
    ];

    public function zone_travail(){
        return $this->belongsTo(Zone_travail::class);
    }

    public function responsable_etablissement() {
        return $this->hasOne(Responsable_etablissement::class);
    }
    public function bloc_etablissements() {
        return $this->hasMany(Bloc_etablissement::class);
    }
    public function camion() {
        return $this->belongsTo(Camion::class);
    }

    public function etage_etablissements(){
        return $this->hasManyDeep(Etage_etablissement::class, [Bloc_etablissement::class]);
    }
    public function bloc_poubelles() {
         return $this->hasManyDeep(Bloc_poubelle::class, [Bloc_etablissement::class, Etage_etablissement::class]);
    }
    public function poubelles(){
        return $this->hasManyDeep(Poubelle::class, [Bloc_etablissement::class, Etage_etablissement::class,Bloc_poubelle::class]);
    }
    public function revenus(){
        return $this->hasOne(Revenu::class);
    }
    protected $dates=['deleted_at'];
}
