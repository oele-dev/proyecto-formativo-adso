# GA6-AA1 — Modelo de base de datos del proyecto

> **Resultado de aprendizaje:** Crear un modelo de base de datos, con base en los requisitos definidos para el proyecto de software, aplicando estándares de calidad y seguridad.
>
> **Fecha límite oficial Zajuna:** ver cronograma de tu ficha (típicamente 26/04 → ajustada a 17/05/2026 con la ventana adicional)

## ¿Qué tienes que entregar?

Aplicas a **TU proyecto formativo** (no al de biblioteca del tutorial) los siguientes artefactos:

### 1. 📐 Modelo conceptual + lógico

En `evidencias/ga6-aa1-modelo-bd/modelo.md` documentas:

- **Listado de entidades** identificadas (mínimo 5)
- **Diagrama entidad-relación** (en formato Mermaid embebido en el markdown — se renderiza en GitHub)
- **Justificación de la normalización** aplicada (1FN, 2FN, 3FN)
- **Restricciones de integridad** (PKs, FKs, UNIQUE, NOT NULL, CHECK)

### 2. 🗄️ Migraciones Laravel

En `database/migrations/` creas las migraciones que materializan tu modelo:

- ≥ 5 tablas (sin contar `users`, `password_resets`, etc. del skeleton)
- Cada tabla con su PK
- Mínimo 3 relaciones FK entre tus tablas
- Mínimo 1 tabla con relación many-to-many (con tabla pivote)
- Las tablas transaccionales y pivote deben usar `softDeletes()`
- Timestamps en todas las tablas

### 3. 🌱 Seeders

En `database/seeders/` poblamos datos de prueba:

- Un `DatabaseSeeder` que llame a los seeders específicos
- Mínimo 3 registros por tabla
- Usar Factories de Laravel para datos realistas

### 4. 🧬 Modelos Eloquent

En `app/Models/` los modelos correspondientes:

- Cada tabla tiene su modelo
- Las relaciones (`hasMany`, `belongsTo`, `belongsToMany`) declaradas
- `$fillable` o `$guarded` definidos correctamente
- Soft deletes vía `use SoftDeletes;` donde aplique

### 5. 🔒 Esquema de seguridad

En `evidencias/ga6-aa1-modelo-bd/seguridad.md` documentas:

- Roles previstos (admin, usuario, ...)
- Qué tablas tienen información sensible
- Estrategia de auditoría (timestamps, soft deletes, columnas `created_by`)
- Cómo se maneja la integridad referencial

## Tests automáticos (autograding)

Cuando hagas push a tu branch `evidencia/ga6-aa1-modelo-bd`, GitHub Actions corre estos tests:

| Test | Puntos | Qué valida |
|------|:------:|------------|
| Migraciones corren | 20 | `php artisan migrate:fresh` sin errores |
| Tablas mínimas existen | 15 | ≥ 5 tablas propias + soft delete columns |
| FK definidas | 20 | ≥ 3 relaciones FK, sin huérfanas |
| Soft deletes donde aplica | 10 | Tablas pivote y transaccionales con `deleted_at` |
| Modelos con relaciones | 15 | Eloquent declarando relaciones |
| Seeders ejecutan | 10 | `php artisan db:seed` sin errores |
| README evidencia llenado | 10 | `modelo.md` + `seguridad.md` con contenido |
| **TOTAL** | **100** | (≥ 80 = aprueba autograding) |

## Cómo trabajar (paso a paso)

### Paso 1 — Estudia el tutorial Biblioteca CIES

```bash
git checkout tutorial/step-01-skeleton
cat docs/tutorial-biblioteca.md
# revisa cada step
git checkout tutorial/step-02-libros-table
git diff tutorial/step-01-skeleton tutorial/step-02-libros-table
```

### Paso 2 — Crea tu branch de evidencia

```bash
git checkout main
git checkout -b evidencia/ga6-aa1-modelo-bd
```

### Paso 3 — Diseña conceptualmente PRIMERO

Antes de tocar Laravel, escribe `evidencias/ga6-aa1-modelo-bd/modelo.md` con tu diagrama ER. **No saltes este paso.**

### Paso 4 — Crea migraciones incrementalmente

```bash
php artisan make:migration create_{tu_entidad}_table
# edita el archivo
php artisan migrate
git add . && git commit -m "feat(ga6-aa1): tabla {entidad}"
```

**Un commit por tabla**, no todo al final.

### Paso 5 — Crea modelos + relaciones

```bash
php artisan make:model {Entidad} -f -s
# edita el modelo, factory y seeder
git commit -m "feat(ga6-aa1): modelo {Entidad} con relaciones"
```

### Paso 6 — Prueba localmente

```bash
php artisan migrate:fresh --seed
php artisan test --filter=Ga6Aa1
```

### Paso 7 — Push y PR

```bash
git push -u origin evidencia/ga6-aa1-modelo-bd
gh pr create --base main --title "GA6-AA1: Modelo BD — {tu nombre}"
```

### Paso 8 — Sube link a Zajuna (entrega oficial)

Cuando el autograding pase (≥ 80%), copia la URL del PR (o del repo) y **pégala en la evidencia GA6-AA1 en Zajuna**. Esa es tu única entrega oficial — no necesitas adjuntar archivos.zip ni nada más.

## Errores comunes

| Síntoma | Causa probable | Solución |
|---------|----------------|----------|
| `migrate:fresh` falla con "Cannot add foreign key" | Orden de migraciones incorrecto | La tabla referenciada tiene que crearse ANTES |
| Test "soft_deletes" falla | Olvidaste `softDeletes()` en migración | Agrégalo y corre `migrate:fresh` |
| "FK not found" en autograding | Usaste `bigInteger` en lugar de `foreignId` | Migra a `foreignId('xxx_id')->constrained()` |
| README test falla | No llenaste `modelo.md` o `seguridad.md` | Reemplaza placeholders `{TODO}` |

## Recursos

- [Tutorial Biblioteca CIES](../../docs/tutorial-biblioteca.md) — dominio de práctica completo
- [COMMITS.md](../../docs/COMMITS.md) — walkthrough de los commits del tutorial
- [Laravel Migrations](https://laravel.com/docs/migrations)
- [Laravel Eloquent Relationships](https://laravel.com/docs/eloquent-relationships)
- [Mermaid ER diagrams](https://mermaid.js.org/syntax/entityRelationshipDiagram.html)

---

> ⚠️ **Recuerda:** la calificación oficial es en **Zajuna**, hecha por el instructor. El autograding es solo feedback automático. Aún si pasas autograding al 100%, el instructor puede observar la evidencia si no aplicaste a tu proyecto real o si copiaste el tutorial.
