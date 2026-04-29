<?php

namespace Database\Factories;

use App\Models\Autor;
use Illuminate\Database\Eloquent\Factories\Factory;

class AutorFactory extends Factory
{
    protected $model = Autor::class;

    public function definition(): array
    {
        return [
            'nombre_completo' => fake()->name(),
            'nacionalidad' => fake()->country(),
        ];
    }
}
