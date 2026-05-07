# Proyecto Formativo ADSO 228118 — Template

> **Stack:** Laravel 11 · Inertia.js · React · Tailwind · MySQL
> **Programa:** Análisis y Desarrollo de Software (228118) — SENA
> **Fichas:** 3235898 / 3235899

Este es el **repositorio plantilla** del proyecto formativo de la fase de Ejecución. Aquí codificas las evidencias técnicas (GA6, GA7, GA8 — parcial GA10) que el cronograma SENA exige.

## ¿Cómo funciona?

1. **Haces fork** de este repo a tu cuenta personal de GitHub.
2. Cuando tu instructor habilita una nueva evidencia (ej: GA6-AA1), **sincronizas** desde upstream y mergeas el `feat/{evidencia-id}` correspondiente.
3. Trabajas **en tu `main`**, agregando código que aplica el patrón a TU dominio.
4. Cuando haces push, **GitHub Actions corre los tests** de todas las evidencias activas.
5. **Pegas la URL de tu repo en la evidencia Zajuna** — esa es tu única entrega oficial.

## Setup local (una sola vez)

Requisitos: PHP 8.2+, Composer, SQLite (viene con PHP, no requiere instalación separada).

```bash
# Después de hacer fork desde GitHub
git clone https://github.com/{tu-usuario}/proyecto-formativo-adso.git
cd proyecto-formativo-adso

# Conecta el repo del instructor como upstream para sincronizar evidencias futuras
git remote add upstream https://github.com/oele-dev/proyecto-formativo-adso.git

composer install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate
```

## ⭐ Cómo abrir el proyecto (importante)

> **Abre el archivo `proyecto-formativo.code-workspace`, NO la carpeta.**

Doble clic al archivo `proyecto-formativo.code-workspace` (o desde VS Code: *File → Open Workspace from File...*). Vas a ver **solo 3 carpetas** en el sidebar:

- 📦 **Base de datos** — donde creas tus migraciones, seeders y factories
- 🧪 **Tests** — los tests que tu código debe pasar (autograding)
- 📋 **Evidencias** — el README de cada evidencia con qué hacer

El resto del proyecto (Laravel core: `app/`, `config/`, `routes/`, `vendor/`, etc.) queda como **caja negra** — no necesitas tocarlo todavía. Lo abriremos cuando lleguemos a las evidencias de interfaces web (GA6-AA3+).

### Comandos que sí vas a usar

Desde terminal en la raíz del proyecto:

```bash
php artisan migrate:fresh --seed   # recrea la BD con datos de prueba
php artisan test                   # corre los tests (autograding local)
```

Eso es todo. Si tu test pasa local, también pasará en GitHub Actions cuando hagas push.

## Flujo por cada evidencia

### Ejemplo con **GA6-AA1 — Modelo de base de datos**

```bash
# 1. Sincronizar desde upstream y traer la evidencia
git fetch upstream
git checkout main
git merge upstream/feat/ga6-aa1-modelo-bd
# Esto agrega: evidencias/ga6-aa1-modelo-bd/ + tests + workflow

# 2. Lee el README de la evidencia
cat evidencias/ga6-aa1-modelo-bd/README.md

# 3. Trabaja: crea migraciones, modelos, etc. PARA TU DOMINIO
php artisan make:migration create_xxx_table

# 4. Prueba localmente
php artisan migrate:fresh
php artisan test

# 5. Commits frecuentes con mensajes claros
git add .
git commit -m "feat(ga6-aa1): tabla xxx con FK a yyy"

# 6. Push (GitHub Actions corre los tests automáticamente)
git push origin main

# 7. Revisa el resultado del autograding en la pestaña "Actions" de tu fork
# 8. Cuando todo esté verde, copia la URL de tu repo y pégala en Zajuna
```

### Tu `main` crece a lo largo del semestre

Cada evidencia que mergeas + tu trabajo en ella se acumula en `main`. Al final del programa, `main` contiene **toda tu app funcionando** — listo como portafolio.

## Tutorial guiado: **Biblioteca CIES**

Para que aprendas el patrón sin trabarte con tu propio dominio, el repo tiene una branch **`tutorial`** donde se construye una biblioteca progresivamente. Los commits están **taggeados paso a paso**.

```bash
git fetch --tags upstream
git tag -l "tutorial/*" | sort
# tutorial/step-00-init
# tutorial/ga6-aa1/step-01-modelo-conceptual
# tutorial/ga6-aa1/step-02-libros-table
# ...
# tutorial/ga6-aa2/step-01-...   (futuras evidencias)
```

Para revisar paso a paso:

```bash
git checkout tutorial/ga6-aa1/step-01-modelo-conceptual
git checkout tutorial/ga6-aa1/step-02-libros-table
git diff tutorial/ga6-aa1/step-01-modelo-conceptual tutorial/ga6-aa1/step-02-libros-table

# Cuando termines de explorar, vuelve a tu main:
git checkout main
```

Tu **proyecto formativo** vive en `main` y aplicas el patrón **a tu dominio**, no al de biblioteca.

## Estructura del repo (lo que sí vas a tocar)

```
.
├── proyecto-formativo.code-workspace  # ← ABRE ESTE archivo en VS Code
├── database/
│   ├── migrations/           # creas tablas aquí
│   ├── seeders/              # datos de prueba
│   └── factories/            # generadores de datos para tests
├── tests/Feature/            # autograding (no editar — solo leer)
├── evidencias/               # README + materiales por evidencia (al mergear feat/*)
└── README.md
```

**Caja negra (no tocar todavía):** `app/`, `config/`, `routes/`, `resources/`, `public/`, `bootstrap/`, `vendor/`, `storage/`, `.github/`. Esto es Laravel internals — lo abriremos cuando llegue GA6-AA3 (interfaces web). Si abres el `.code-workspace`, no los verás en el sidebar.

## Tabla de evidencias automatizables

| Evidencia | Branch upstream a mergear | Estado |
|-----------|---------------------------|--------|
| GA6-AA1 — Modelo BD | `feat/ga6-aa1-modelo-bd` | ✅ Disponible |
| GA6-AA2 — SQL DDL/DML | `feat/ga6-aa2-sql` | 🚧 Pendiente |
| GA6-AA4 — HTML/CSS/Tailwind | `feat/ga6-aa4-plantillas` | 🚧 Pendiente |
| GA7-AA1 — Versionamiento | `feat/ga7-aa1-git` | 🚧 Pendiente |
| GA7-AA2 — Estándares | `feat/ga7-aa2-estandares` | 🚧 Pendiente |
| ...resto se habilita en su momento | | |

## Reglas de juego

✅ **Sí:**
- Commitear seguido (≥ 1 vez al día)
- Mensajes de commit en español, [convencionales](https://www.conventionalcommits.org/)
- Pedir ayuda en Discord cuando llevas 30 min trabado
- Aplicar el tutorial **a tu propio proyecto** (no al de biblioteca)
- Tu fork debe estar **público** para que Actions corra gratis

❌ **No:**
- Copiar literalmente el código del tutorial — los tests detectan eso
- Usar `--no-verify` o saltarte hooks
- Hacer push sin probar localmente
- Esperar al último día para empezar la evidencia

## Soporte

- **Discord (sincrónico):** martes 5pm (3235898) · miércoles 5pm (3235899)
- **Foro Zajuna:** preguntas asincrónicas
- **Email instructor:** olcaicedo@sena.edu.co

## Calificación

El autograding **NO califica** oficialmente — te da feedback. La calificación oficial es **en Zajuna**, con base en:

1. ✅ Que pase autograding (tests verdes)
2. ✅ Que el código aplique el patrón al **TU dominio** (no copiado)
3. ✅ Que hayas hecho commits incrementales (no un solo commit gigante)
4. ✅ Que el README de la evidencia esté llenado correctamente

---

> 🚀 *"El programa es maratón, no sprint. Un commit pequeño cada día > un commit gigante el último día."*
