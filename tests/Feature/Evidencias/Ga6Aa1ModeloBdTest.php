<?php

namespace Tests\Feature\Evidencias;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Schema;
use Tests\TestCase;

/**
 * Autograding · GA6-AA1 — Modelo de base de datos del proyecto
 *
 * Estos tests NO califican oficialmente. Validan que el aprendiz aplicó
 * correctamente el patrón aprendido en el tutorial Biblioteca CIES a su
 * propio dominio del proyecto formativo.
 *
 * Las "tablas del skeleton" (users, password_reset_tokens, sessions, cache,
 * jobs, failed_jobs, migrations, personal_access_tokens) se excluyen del
 * conteo: solo cuentan las tablas creadas por el aprendiz.
 */
class Ga6Aa1ModeloBdTest extends TestCase
{
    use RefreshDatabase;

    private const SKELETON_TABLES = [
        'users', 'password_reset_tokens', 'sessions', 'cache', 'cache_locks',
        'jobs', 'job_batches', 'failed_jobs', 'migrations', 'personal_access_tokens',
    ];

    private function tablasDelAprendiz(): array
    {
        $driver = DB::connection()->getDriverName();
        $tablas = match ($driver) {
            'sqlite' => DB::select("SELECT name FROM sqlite_master WHERE type='table' AND name NOT LIKE 'sqlite_%'"),
            'mysql' => DB::select("SHOW TABLES"),
            default => [],
        };

        $nombres = array_map(fn ($r) => array_values((array) $r)[0], $tablas);

        return array_values(array_diff($nombres, self::SKELETON_TABLES));
    }

    /** @test */
    public function test_tablas_minimas_existen(): void
    {
        $tablas = $this->tablasDelAprendiz();

        $this->assertGreaterThanOrEqual(
            5,
            count($tablas),
            "Se esperan ≥ 5 tablas propias del proyecto. Encontradas: " . count($tablas) . " (" . implode(', ', $tablas) . ")"
        );
    }

    /** @test */
    public function test_foreign_keys_definidas(): void
    {
        $tablas = $this->tablasDelAprendiz();
        $totalFks = 0;
        $tablasConFk = [];

        foreach ($tablas as $tabla) {
            $fks = $this->foreignKeysDeTabla($tabla);
            if (count($fks) > 0) {
                $tablasConFk[] = $tabla;
                $totalFks += count($fks);
            }
        }

        $this->assertGreaterThanOrEqual(
            3,
            $totalFks,
            "Se esperan ≥ 3 foreign keys entre tablas. Encontradas: $totalFks. Tablas con FK: " . implode(', ', $tablasConFk)
        );
    }

    /** @test */
    public function test_soft_deletes_donde_aplica(): void
    {
        $tablas = $this->tablasDelAprendiz();
        $conSoftDelete = [];

        foreach ($tablas as $tabla) {
            if (Schema::hasColumn($tabla, 'deleted_at')) {
                $conSoftDelete[] = $tabla;
            }
        }

        $this->assertGreaterThanOrEqual(
            1,
            count($conSoftDelete),
            "Se espera ≥ 1 tabla con soft deletes (columna deleted_at). Encontradas: " . count($conSoftDelete)
        );
    }

    /** @test */
    public function test_modelos_tienen_relaciones(): void
    {
        $modelosPath = app_path('Models');
        $this->assertDirectoryExists($modelosPath, "La carpeta app/Models no existe");

        $archivos = File::files($modelosPath);
        $modelosDelAprendiz = array_filter($archivos, fn ($f) => $f->getFilename() !== 'User.php');

        $this->assertGreaterThanOrEqual(
            3,
            count($modelosDelAprendiz),
            "Se esperan ≥ 3 modelos propios en app/Models (sin contar User.php)"
        );

        $relacionesEncontradas = 0;
        foreach ($modelosDelAprendiz as $archivo) {
            $contenido = File::get($archivo->getPathname());
            if (preg_match('/(hasMany|hasOne|belongsTo|belongsToMany|morphMany|morphTo)\s*\(/', $contenido)) {
                $relacionesEncontradas++;
            }
        }

        $this->assertGreaterThanOrEqual(
            2,
            $relacionesEncontradas,
            "Se esperan ≥ 2 modelos declarando relaciones Eloquent. Encontrados: $relacionesEncontradas"
        );
    }

    /** @test */
    public function test_readme_evidencia_llenado(): void
    {
        $modeloPath = base_path('evidencias/ga6-aa1-modelo-bd/modelo.md');
        $seguridadPath = base_path('evidencias/ga6-aa1-modelo-bd/seguridad.md');

        $this->assertFileExists($modeloPath, "Falta evidencias/ga6-aa1-modelo-bd/modelo.md");
        $this->assertFileExists($seguridadPath, "Falta evidencias/ga6-aa1-modelo-bd/seguridad.md");

        foreach ([$modeloPath, $seguridadPath] as $path) {
            $contenido = File::get($path);
            $placeholders = substr_count($contenido, '{TODO');
            $this->assertLessThan(
                10,
                $placeholders,
                basename($path) . " todavía tiene $placeholders placeholders {TODO} sin llenar"
            );
        }
    }

    /** @test */
    public function test_seeders_ejecutan_sin_errores(): void
    {
        $this->artisan('db:seed', ['--force' => true])
            ->assertExitCode(0);

        $tablas = $this->tablasDelAprendiz();
        $tablasConDatos = 0;

        foreach ($tablas as $tabla) {
            if (DB::table($tabla)->count() > 0) {
                $tablasConDatos++;
            }
        }

        $this->assertGreaterThanOrEqual(
            3,
            $tablasConDatos,
            "Se esperan ≥ 3 tablas pobladas por seeders. Encontradas: $tablasConDatos"
        );
    }

    private function foreignKeysDeTabla(string $tabla): array
    {
        $driver = DB::connection()->getDriverName();

        return match ($driver) {
            'sqlite' => DB::select("PRAGMA foreign_key_list($tabla)"),
            'mysql' => DB::select(
                "SELECT * FROM information_schema.KEY_COLUMN_USAGE WHERE TABLE_SCHEMA = DATABASE() AND TABLE_NAME = ? AND REFERENCED_TABLE_NAME IS NOT NULL",
                [$tabla]
            ),
            default => [],
        };
    }
}
