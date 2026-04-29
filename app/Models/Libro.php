<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Libro extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'titulo',
        'isbn',
        'anio_publicacion',
        'copias_disponibles',
        'categoria_id',
    ];
}
