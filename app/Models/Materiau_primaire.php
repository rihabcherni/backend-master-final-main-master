<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ProductionPoubelle\MateriauxPrimaire as MateriauxPrimaireResource;

class Materiau_primaire extends Model
{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'fournisseur_id',
        'nom_materiel',
        'prix_unitaire',
        'quantite',
        'prix_total',
    ];
    public function fournisser()
    {
        return $this->belongsTo(Fournisser::class);
    }
    protected $dates=['deleted_at'];
    public static function getMateriauxPrimaire(){
        $materiauxPrimaire = MateriauxPrimaireResource::collection(Materiau_primaire::all());
        return $materiauxPrimaire;
    }

    public static function getMateriauxPrimaireById($id){
        $materiauxPrimaire = MateriauxPrimaireResource::collection(Materiau_primaire::where('id',$id)->get());
        return $materiauxPrimaire;
    }
}
