<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Poubelle extends Model{
    use HasFactory,  SoftDeletes;
    protected $fillable = [
        'bloc_poubelle_id',
        'nom',
        'QRcode',
        'type',
        'Etat',
    ];
    public function blocoubelle(){
        return $this->belongsTo(Bloc_poubelle::class);
    }
    public function Etage(){
        return $this->belongsToThrough(Etage::class, Poubelle::class);
    }
    protected $dates=['deleted_at'];

}

