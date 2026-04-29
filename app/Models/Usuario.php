<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    protected $table = 'usuarios';

    protected $fillable = ['nombre', 'email', 'tipo'];

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
}
