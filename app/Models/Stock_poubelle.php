<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\ProductionPoubelle\Stock_poubelle as StockPoubelleResource;

class Stock_poubelle extends Model
{
    use HasFactory , SoftDeletes;

    protected $fillable = [
        'type_poubelle',
        'quantite_disponible',
        'description',
        'photo',
    ];
    public function blocPoubelle()
    {
        return $this->belongsTo(Bloc_poubelle::class);
    }

    public function rating_poubelle()
    {
        return $this->hasOne(Rating_poubelle::class);
    }
    public static function getStockPoubelle(){
        $stockPoubelle = StockPoubelleResource::collection(Stock_poubelle::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $stockPoubelle;
    }

    public static function getStockPoubelleById($id){
        $stockPoubelle = StockPoubelleResource::collection(Stock_poubelle::where('id',$id)->get());
        return $stockPoubelle;
    }
}
