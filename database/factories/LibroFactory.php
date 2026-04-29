<?php

namespace Database\Factories;

use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibroFactory extends Factory
{
    protected $model = Libro::class;

    public function definition(): array
    {
        return [
            'titulo' => fake()->sentence(4),
            'isbn' => fake()->unique()->isbn13(),
            'anio_publicacion' => fake()->numberBetween(1950, 2025),
            'copias_disponibles' => fake()->numberBetween(1, 10),
            'categoria_id' => Categoria::factory(),
        ];
    }
}
