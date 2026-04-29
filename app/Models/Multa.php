<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Multa extends Model
{
    protected $fillable = ['prestamo_id', 'monto', 'pagada', 'fecha_pago'];

    protected $casts = [
        'pagada' => 'boolean',
        'fecha_pago' => 'datetime',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }
}
