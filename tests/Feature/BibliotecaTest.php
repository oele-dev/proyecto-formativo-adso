<?php

namespace Tests\Feature;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Libro;
use App\Models\Multa;
use App\Models\Prestamo;
use App\Models\Usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Tests funcionales del modelo Biblioteca CIES.
 *
 * Demuestran que:
 * - Las relaciones Eloquent funcionan en ambos sentidos
 * - Soft deletes preservan registros
 * - Las restricciones de integridad se respetan
 */
class BibliotecaTest extends TestCase
{
    use RefreshDatabase;

    public function test_un_libro_pertenece_a_una_categoria(): void
    {
        $categoria = Categoria::factory()->create(['nombre' => 'Programación']);
        $libro = Libro::factory()->create(['categoria_id' => $categoria->id]);

        $this->assertEquals('Programación', $libro->categoria->nombre);
    }

    public function test_un_libro_puede_tener_multiples_autores(): void
    {
        $libro = Libro::factory()->create();
        $autores = Autor::factory()->count(3)->create();

        $libro->autores()->attach($autores);

        $this->assertCount(3, $libro->autores);
    }

    public function test_un_autor_puede_tener_multiples_libros(): void
    {
        $autor = Autor::factory()->create();
        $libros = Libro::factory()->count(2)->create();

        $autor->libros()->attach($libros);

        $this->assertCount(2, $autor->libros);
    }

    public function test_soft_delete_preserva_el_prestamo(): void
    {
        $prestamo = Prestamo::factory()->create();

        $prestamo->delete();

        $this->assertEquals(0, Prestamo::count());
        $this->assertEquals(1, Prestamo::withTrashed()->count());
    }

    public function test_un_prestamo_puede_generar_una_multa(): void
    {
        $prestamo = Prestamo::factory()->create();
        $multa = Multa::factory()->create([
            'prestamo_id' => $prestamo->id,
            'monto' => 5000,
        ]);

        $this->assertEquals(5000, $prestamo->multa->monto);
        $this->assertEquals($prestamo->id, $multa->prestamo->id);
    }

    public function test_isbn_debe_ser_unico(): void
    {
        Libro::factory()->create(['isbn' => '978-3-16-148410-0']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Libro::factory()->create(['isbn' => '978-3-16-148410-0']);
    }

    public function test_email_de_usuario_debe_ser_unico(): void
    {
        Usuario::factory()->create(['email' => 'test@cies.edu.co']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Usuario::factory()->create(['email' => 'test@cies.edu.co']);
    }
}
