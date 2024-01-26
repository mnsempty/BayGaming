<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    // terminar enlace products (laravel002)
    public function catogories(){
        return $this->belongsToMany(Materias::class,'materias_id','alumno_id','alumno_materia_id');
    }
}
