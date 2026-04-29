# Walkthrough — Tutorial Biblioteca CIES (commits-as-slides)

Este documento mapea **cada commit del tutorial** a su lección. Diseñado para que el instructor proyecte `git checkout` en clase y los aprendices vean la progresión paso a paso.

## Pre-requisitos en el repo

Cada step es un commit con **tag** `tutorial/step-NN-descripcion`. Para listar:

```bash
git tag -l "tutorial/*" | sort
```

Para navegar en clase:

```bash
git checkout tutorial/step-01-skeleton    # punto de partida
git checkout tutorial/step-02-libros-table # siguiente lección
git diff tutorial/step-01 tutorial/step-02 # qué cambió
```

## Mapa de pasos

| Step | Tag | Tema | Archivos clave | Concepto |
|:----:|-----|------|----------------|----------|
| 00 | `tutorial/step-00-init` | Skeleton Laravel | `composer.json`, `.env.example` | Punto de partida limpio |
| 01 | `tutorial/step-01-modelo-conceptual` | Diagrama ER en Markdown | `docs/tutorial-biblioteca.md` | **Pensar antes de codificar** |
| 02 | `tutorial/step-02-libros-table` | Primera migración | `database/migrations/...create_libros_table.php` | `Schema::create`, columnas básicas |
| 03 | `tutorial/step-03-autores-table` | Segunda entidad | `...create_autores_table.php` | Independiente, sin FK aún |
| 04 | `tutorial/step-04-libro-autor-pivot` | Relación M:N | `...create_libro_autor_table.php` | Tabla pivote, `foreignId().constrained()` |
| 05 | `tutorial/step-05-prestamos-table` | Tabla transaccional | `...create_prestamos_table.php` | FK múltiples, `enum`, `date` |
| 06 | `tutorial/step-06-soft-deletes` | Borrado lógico | migración + modelos | `softDeletes()`, `deleted_at` |
| 07 | `tutorial/step-07-eloquent-models` | Modelos con relaciones | `app/Models/Libro.php`, etc. | `belongsTo`, `belongsToMany`, `hasMany` |
| 08 | `tutorial/step-08-factories` | Datos sintéticos | `database/factories/` | Faker + Factory pattern |
| 09 | `tutorial/step-09-seeders` | Población de BD | `database/seeders/` | `DatabaseSeeder`, llamadas en cascada |
| 10 | `tutorial/step-10-tests` | Tests funcionales | `tests/Feature/...` | RefreshDatabase, asserts de modelo |
| 11 | `tutorial/step-11-readme-final` | Documentación final | `docs/tutorial-biblioteca.md` | Cerrar la evidencia |

## Cómo se construyen estos tags (para el instructor)

> Los tags ya vienen listos en el template. Esta sección es referencia si necesitas reconstruir o extender.

```bash
# Después de hacer el commit "step-02"
git tag -a tutorial/step-02-libros-table -m "Tutorial step 2: tabla libros"

# Push de tags al remoto
git push --tags
```

## Patrón para EXTENDER a otra evidencia

Cuando quieras armar el tutorial de GA6-AA2 (SQL DDL/DML), aplica el mismo patrón:

```
tutorial-ga6-aa2/step-01-...
tutorial-ga6-aa2/step-02-...
```

Mantén los namespaces separados con prefijo de evidencia.

## Recomendación pedagógica

- **No leas el commit message.** En clase, primero explica el problema verbalmente, luego haz `git checkout` y deja que el diff hable.
- **Para preguntar**: deja la pantalla en `git diff step-N step-N+1` y pregunta "¿qué creen que hace este cambio?" antes de explicar.
- **Si alguien va más rápido:** muéstrale `git checkout tutorial/step-10-tests` para que vea el objetivo final.
- **Si alguien va más lento:** quédate en step actual; vuelve atrás con `git checkout tutorial/step-{previous}`.
