<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionDechet\Detail_commande_dechet as DetailCommandeDechetResource;

class Detail_commande_dechet extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'commande_dechet_id',
        'dechet_id',
        'quantite',
    ];

    public function commande_dechet()
    {
        return $this->belongsTo(Commande_dechet::class);
    }
    public static function getDetailCommandeDechet(){
        $DetailCommandeDechet = DetailCommandeDechetResource::collection(Detail_commande_dechet::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at', 'commande_dechet','dechet'])->toArray();
        });
        return $DetailCommandeDechet;
    }

    public static function getDetailCommandeDechetById($id){
        $DetailCommandeDechet = DetailCommandeDechetResource::collection(Detail_commande_dechet::where('id',$id)->get());
        return $DetailCommandeDechet;
    }
}
