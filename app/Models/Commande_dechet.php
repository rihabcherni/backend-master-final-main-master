<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionDechet\Commande_dechet as CommandeDechetResource;

class Commande_dechet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'client_dechet_id',
        'quantite_plastique',
        'quantite_papier',
        'quantite_composte',
        'quantite_canette',
        'prix_plastique',
        'prix_papier',
        'prix_composte',
        'prix_canette',
        'montant_total',
        'type_paiment',
        'date_commande',
        'date_livraison',
    ];

    public function client_dechet(){
        return $this->hasOne(Client_dechet::class);
    }
        protected $dates=['deleted_at'];

    public static function getCommandeDechet(){
        $commandeDechet = CommandeDechetResource::collection(Commande_dechet::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at', 'client_dechet'])->toArray();
        });
        return $commandeDechet;
    }

    public static function getCommandeDechetById($id){
        $commandeDechet = CommandeDechetResource::collection(Commande_dechet::where('id',$id)->get());
        return $commandeDechet;
    }
    public static function  getCommandeDechetByIdTrashed($id){
        $commandeDechet = CommandeDechetResource::collection(Commande_dechet::withTrashed()->where('id' ,  $id )->get());
        return $commandeDechet;
    }
}
