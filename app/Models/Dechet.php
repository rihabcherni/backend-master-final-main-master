<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\GestionDechet\Dechet as DechetResource;

class Dechet extends Model
{
    use HasFactory,  SoftDeletes;

    protected $fillable = [
        'type_dechet',
        'prix_unitaire',
        'photo',
        'pourcentage_remise'
    ];
    public function depots()
    {
        return $this->hasMany(Depot::class);
    }
    public function rating_poubelle()
    {
        return $this->hasOne(Rating_dechet::class);
    }

    protected $dates=['deleted_at'];
    public static function getDechet(){
        $dechet = DechetResource::collection(Dechet::all())->map(function ($item, $key) {
            return collect($item)->except(['deleted_at'])->toArray();
        });
        return $dechet;
    }

    public static function getDechetById($id){
        $dechet = DechetResource::collection(Dechet::where('id',$id)->get());
        return $dechet;
    }
    public static function getDechetByIdTrashed($id){
        $dechet = DechetResource::collection(Dechet::withTrashed()->where('id' ,  $id )->get());
        return $dechet;
    }
}
