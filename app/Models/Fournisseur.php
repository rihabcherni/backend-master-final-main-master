<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ProductionPoubelle\Fournisseur as FournisseurResource;

class Fournisseur extends Model{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'CIN',
        'photo',
        'numero_telephone',
        'email',
        'adresse',
    ];
    public function materiau_primaires()
    {
        return $this->belongsTo(Materiau_primaire::class);
    }
    protected $dates=['deleted_at'];
    public static function getFournisseur(){ 
        $fournisseur = FournisseurResource::collection(Fournisseur::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $fournisseur;
    }

    public static function getFournisseurById($id){
        $fournisseur = FournisseurResource::collection(Fournisseur::where('id',$id)->get());
        return $fournisseur;
    }
}
