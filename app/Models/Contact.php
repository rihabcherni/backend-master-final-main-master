<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Resources\Contact as ContactResource;

class Contact extends Model
{
    use HasFactory , SoftDeletes;
    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'numero_telephone',
        'message'
        ];
    protected $dates=['deleted_at'];
    public static function getContact(){
        $contact = ContactResource::collection(Contact::all());
        return $contact;
    }

    public static function getContactById($id){
        $contact = ContactResource::collection(Contact::where('id',$id)->get());
        return $contact;
    }
}
