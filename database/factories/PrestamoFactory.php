<?php

namespace Database\Factories;

use App\Models\Libro;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Database\Eloquent\Factories\Factory;

class PrestamoFactory extends Factory
{
    protected $model = Prestamo::class;

    public function definition(): array
    {
        $fechaPrestamo = fake()->dateTimeBetween('-30 days', 'now');

        return [
            'libro_id' => Libro::factory(),
            'usuario_id' => Usuario::factory(),
            'fecha_prestamo' => $fechaPrestamo,
            'fecha_devolucion_esperada' => fake()->dateTimeBetween($fechaPrestamo, '+15 days'),
            'fecha_devolucion_real' => null,
            'estado' => 'activo',
        ];
    }
}
