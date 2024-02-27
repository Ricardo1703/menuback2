<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;
    protected $fillable = ['user_id', 'name', 'descripcion', 'precio', 'imagen'];

    //Uno a muchos
    public function user(){
        return $this->belongsTo('App\Models\User');
    }

}
