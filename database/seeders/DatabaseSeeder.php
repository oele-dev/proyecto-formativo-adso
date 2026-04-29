<?php

namespace Database\Seeders;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Libro;
use App\Models\Multa;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Datos de prueba para Biblioteca CIES
        $categorias = Categoria::factory()->count(5)->create();
        $autores = Autor::factory()->count(20)->create();

        // Libros con categoria + autores aleatorios (M:N)
        Libro::factory()
            ->count(30)
            ->recycle($categorias)
            ->create()
            ->each(function ($libro) use ($autores) {
                $libro->autores()->attach(
                    $autores->random(rand(1, 3))->pluck('id')
                );
            });

        $usuarios = Usuario::factory()->count(15)->create();

        // Prestamos con libros + usuarios reales
        $prestamos = Prestamo::factory()
            ->count(40)
            ->recycle($usuarios)
            ->recycle(Libro::all())
            ->create();

        // Multas para 30% de prestamos vencidos
        Multa::factory()
            ->count(12)
            ->recycle($prestamos)
            ->create();
    }
}
