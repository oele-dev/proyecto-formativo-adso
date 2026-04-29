# Proyecto Formativo ADSO 228118 — Template

> **Stack:** Laravel 11 · Inertia.js · React · Tailwind · MySQL
> **Programa:** Análisis y Desarrollo de Software (228118) — SENA
> **Fichas:** 3235898 / 3235899

Este es el **repositorio plantilla** para el proyecto formativo de la fase de Ejecución. Aquí codificas las evidencias técnicas (GA6, GA7, GA8, GA9 — parcial GA10) que el cronograma SENA exige.

## ¿Cómo funciona?

1. **Haces fork** de este repo a tu cuenta personal de GitHub.
2. Cada **evidencia técnica** se entrega en un **branch propio** (`evidencia/ga6-aa1-modelo-bd`, etc.).
3. Cuando haces push, **GitHub Actions corre tests automáticos** que validan tu trabajo (gratis en repos públicos).
4. Una vez los tests pasan, **abres un Pull Request** a tu propio `main`.
5. **Pegas la URL del repo (o del PR específico) en la evidencia Zajuna** — esa es tu única entrega oficial.

## Setup local

Requisitos: PHP 8.2+, Composer, Node 20+, MySQL 8 (o SQLite para desarrollo).

```bash
# 1. Fork del template desde GitHub UI (botón "Fork" arriba a la derecha)
# 2. Clona tu fork
git clone https://github.com/{tu-usuario}/proyecto-formativo-adso.git
cd proyecto-formativo-adso

composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
npm run dev
```

Servidor en `http://localhost:8000`.

## Estructura del repo

```
.
├── app/                      # código Laravel (modelos, controllers, etc.)
├── database/migrations/      # migraciones — clave para GA6-AA1, GA6-AA2
├── resources/js/             # componentes React + Inertia
├── tests/Feature/Evidencias/ # tests por evidencia (autograding)
├── evidencias/               # carpeta por evidencia con instrucciones
│   └── ga6-aa1-modelo-bd/
│       └── README.md         # qué entregar exactamente
├── .github/workflows/        # GitHub Actions (autograding)
└── docs/
    ├── COMMITS.md            # walkthrough "tag-as-checkpoint" del tutorial
    └── tutorial-biblioteca.md # dominio guiado (Biblioteca CIES)
```

## Tutorial guiado: **Biblioteca CIES**

Para que aprendas el patrón sin trabarte con tu propio dominio, el repo trae un tutorial completo del modelado de una biblioteca. Los commits están **taggeados paso a paso**:

```bash
git fetch --tags
git tag -l "tutorial/*" | sort
# tutorial/step-01-modelo-conceptual
# tutorial/step-02-libros-table
# tutorial/step-03-autores-table
# tutorial/step-04-libro-autor-pivot
# tutorial/step-05-prestamos
# tutorial/step-06-soft-deletes
# tutorial/step-07-eloquent-models
# tutorial/step-08-factories
# tutorial/step-09-seeders
# tutorial/step-10-tests
```

Para revisar paso a paso:

```bash
git checkout tutorial/step-01-modelo-conceptual
# ...explora, lee...
git diff tutorial/step-01-modelo-conceptual tutorial/step-02-libros-table
# ...ves exactamente qué cambia...
git checkout tutorial/step-02-libros-table
```

Tu **proyecto formativo** vive en `main` y aplicas el patrón **a tu dominio**, no al de biblioteca.

## Flujo de entrega de una evidencia

Ejemplo con **GA6-AA1 — Modelo de base de datos**:

```bash
# 1. Crea tu branch
git checkout main
git checkout -b evidencia/ga6-aa1-modelo-bd

# 2. Lee el README de la evidencia
cat evidencias/ga6-aa1-modelo-bd/README.md

# 3. Trabajas: creas migraciones, modelos, etc.
php artisan make:migration create_xxx_table

# 4. Pruebas localmente
php artisan migrate:fresh
php artisan test --filter=Ga6Aa1

# 5. Commits frecuentes con mensajes claros
git add .
git commit -m "feat(ga6-aa1): tabla xxx con FK a yyy"

# 6. Push (GitHub Actions corre los tests automáticos)
git push -u origin evidencia/ga6-aa1-modelo-bd

# 7. Revisa el resultado del autograding en la pestaña "Actions" de tu fork
# 8. Cuando todo pase, abre PR a tu main
gh pr create --base main --title "GA6-AA1: Modelo de base de datos"

# 9. Copia la URL del PR (o del repo) y pégala en la evidencia Zajuna
```

## Tabla de evidencias automatizables

| Evidencia | Branch | Tests | Estado |
|-----------|--------|-------|--------|
| GA6-AA1 — Modelo BD | `evidencia/ga6-aa1-modelo-bd` | `Ga6Aa1Test` | ✅ Lista |
| GA6-AA2 — SQL DDL/DML | `evidencia/ga6-aa2-sql` | `Ga6Aa2Test` | 🚧 Pendiente |
| GA6-AA4 — HTML/CSS/Tailwind | `evidencia/ga6-aa4-plantillas` | `Ga6Aa4Test` | 🚧 Pendiente |
| GA7-AA1 — Versionamiento | `evidencia/ga7-aa1-git` | `Ga7Aa1Test` | 🚧 Pendiente |
| GA7-AA2 — Estándares | `evidencia/ga7-aa2-estandares` | (Pint + ESLint) | 🚧 Pendiente |
| ...resto se irá habilitando en su momento | | | |

## Reglas de juego

✅ **Sí:**
- Commitear seguido (≥ 1 vez al día)
- Mensajes de commit en español, claros, [convencionales](https://www.conventionalcommits.org/)
- Pedir ayuda en Discord cuando llevas 30 min trabado
- Aplicar el tutorial **a tu propio proyecto** (no al de biblioteca)
- Tu fork debe estar **público** para que Actions corra gratis

❌ **No:**
- Copiar literalmente el código del tutorial — los tests detectan eso
- Usar `--no-verify` o saltarte hooks
- Hacer push directo a `main` (siempre PR)
- Esperar al último día para empezar la evidencia

## Soporte

- **Discord (sincrónico):** martes 5pm (3235898) · miércoles 5pm (3235899)
- **Foro Zajuna:** preguntas asincrónicas
- **Email instructor:** olcaicedo@sena.edu.co

## Calificación

El autograding **NO califica** oficialmente — te da feedback de "¿está bien estructurado?". La calificación oficial es **en Zajuna**, hecha por el instructor, con base en:

1. ✅ Que pase autograding (≥ 80% de tests verdes)
2. ✅ Que el código aplique el patrón al **TU dominio** (no copiado)
3. ✅ Que hayas hecho commits incrementales (no un solo commit gigante)
4. ✅ Que el README de la evidencia esté llenado correctamente

---

> 🚀 *"El programa es maratón, no sprint. Un commit pequeño cada día > un commit gigante el último día."*
