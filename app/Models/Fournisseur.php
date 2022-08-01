<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
