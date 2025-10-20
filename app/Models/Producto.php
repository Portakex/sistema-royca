<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    // Añade esta propiedad
    protected $fillable = [
        'codigo',
        'nombre',
        'marca',
        'modelo',
        'medidas',
        'unidades',
        'tipo',
        'descripcion',
    ];
}