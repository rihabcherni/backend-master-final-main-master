<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Revenu extends Model{
    use HasFactory;
    protected $fillable = [
        'etablissement_id',
        'mois',
        'quantite_plastique_menusel',
        'quantite_papier_menusel',
        'quantite_composte_menusel',
        'quantite_canette_menusel',
        'revenu_total',
        'revenu_gestionnaire',
        'revenu_responsable',
    ];
    public function etablissement(){
        return $this->belongsTo(Etablissement::class);
    }
    protected $dates=['deleted_at'];
}
