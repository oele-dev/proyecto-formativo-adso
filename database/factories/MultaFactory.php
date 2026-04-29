<?php

namespace Database\Factories;

use App\Models\Multa;
use App\Models\Prestamo;
use Illuminate\Database\Eloquent\Factories\Factory;

class MultaFactory extends Factory
{
    protected $model = Multa::class;

    public function definition(): array
    {
        return [
            'prestamo_id' => Prestamo::factory(),
            'monto' => fake()->randomFloat(2, 500, 50000),
            'pagada' => fake()->boolean(30),
        ];
    }
}
