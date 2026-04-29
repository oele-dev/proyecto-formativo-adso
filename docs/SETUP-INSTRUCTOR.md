# Setup del template repo (para el instructor)

Este overlay (lo que hay en `2_Ejecucion/template-laravel/` del repo Courses) NO es un repo Laravel completo — solo trae los archivos SENA-específicos. Necesitas **bootstraperarlo** sobre un Laravel skeleton fresco antes de subirlo a GitHub.

## Pasos (una sola vez)

### 1. Bootstrappear el template repo localmente

```bash
# 1.1 — Crear Laravel skeleton fresco
composer create-project laravel/laravel proyecto-formativo-adso
cd proyecto-formativo-adso

# 1.2 — Copiar el overlay del repo Courses
cp -R /Users/oele/Solopreneur/Courses/2_Ejecucion/template-laravel/.github .
cp -R /Users/oele/Solopreneur/Courses/2_Ejecucion/template-laravel/evidencias .
cp -R /Users/oele/Solopreneur/Courses/2_Ejecucion/template-laravel/docs .
cp /Users/oele/Solopreneur/Courses/2_Ejecucion/template-laravel/README.md .

# Tests específicos
mkdir -p tests/Feature/Evidencias
cp /Users/oele/Solopreneur/Courses/2_Ejecucion/template-laravel/tests/Feature/Evidencias/Ga6Aa1ModeloBdTest.php tests/Feature/Evidencias/

# 1.3 — Instalar Inertia + React + Tailwind (RILT)
php artisan install:inertia-react   # si usas Breeze: php artisan breeze:install react
npm install
npm run build

# 1.4 — Commit inicial
git init
git add .
git commit -m "chore: skeleton Laravel + overlay SENA ADSO"
git tag tutorial/step-00-init
```

### 2. Construir los tags del tutorial

Cada step se construye así (ejemplo step-02):

```bash
php artisan make:migration create_libros_table
# editas el archivo
git add database/migrations/...create_libros_table.php
git commit -m "feat(tutorial): step 02 - tabla libros"
git tag -a tutorial/step-02-libros-table -m "Tabla libros con ISBN único"
```

Repetir para los 11 steps de `docs/COMMITS.md`. Sugerencia: hazlo en una sentada de 2-3 horas ANTES de la sesión 06/05.

### 3. Crear repo público en GitHub

```bash
# Necesitas gh CLI autenticado
gh auth login

# Crea el repo público (puede ir en tu cuenta personal o en una org)
gh repo create proyecto-formativo-adso \
    --public \
    --source=. \
    --push

# Push de tags
git push --tags
```

### 4. Marcar como template repository

- Settings del repo en GitHub
- Checkbox **"Template repository"** ✅
- Esto le da a los aprendices el botón **"Use this template"** (más limpio que Fork)

### 5. Distribuir el link a los aprendices

Comparte la URL del repo en:

- 📢 **Anuncio Zajuna** (foro de cada ficha) — anuncio oficial
- 🎓 **Sesión sincrónica del 06/05** — slide del deck con la URL
- 💬 **Discord** — pinneado en el canal

Texto sugerido para el anuncio:

```
🚀 Apertura Fase de Ejecución — repo plantilla del proyecto

Para las evidencias técnicas de GA6, GA7 y GA8 vamos a usar GitHub.

1. Crea cuenta en github.com (gratis si no tienes)
2. Ve al repo plantilla: https://github.com/{tu-usuario}/proyecto-formativo-adso
3. Click "Use this template" → "Create a new repository"
4. Marca tu repo como PÚBLICO (para que Actions corra gratis)
5. Cuando entregues evidencia, pega la URL de tu repo en Zajuna

Detalles en la sesión sincrónica del 06/05.
```

## Checklist antes del 06/05

- [ ] Laravel skeleton creado localmente
- [ ] Overlay copiado encima
- [ ] Inertia + React + Tailwind instalado y `npm run build` pasa
- [ ] Los 11 commits con tags `tutorial/step-NN` hechos
- [ ] Repo público en GitHub con tags pusheados
- [ ] Marcado como "Template repository"
- [ ] Probaste el flujo: fork de prueba, push a `evidencia/ga6-aa1-modelo-bd`, verificar Actions corre y los tests pasan
- [ ] Slide del 06/05 con la URL del repo embebida
- [ ] Anuncio Zajuna preparado para el 07/05

## Tu workflow de calificación (por evidencia)

1. Aprendiz pega URL del PR/repo en Zajuna
2. Abres el link → revisas el repo:
   - ¿Pasó autograding? (✅ verde en Actions)
   - ¿Aplicó patrón a SU dominio o copió biblioteca?
   - ¿Commits incrementales o un solo gigante?
   - ¿Llenó `modelo.md` y `seguridad.md`?
3. Calificas en Zajuna como siempre

**Tiempo estimado por aprendiz:** 5-10 minutos (similar a revisar un .zip, pero con más insumos).

## Troubleshooting

### "Aprendiz dice que Actions no corre"

- Verifica que su fork sea **público** (Actions es gratis solo en públicos)
- Que el branch empiece con `evidencia/`
- Que tenga al menos un commit con cambios

### "Test no pasa pero localmente sí"

Verifica que `phpunit.xml` configure SQLite para testing:

```xml
<env name="DB_CONNECTION" value="sqlite"/>
<env name="DB_DATABASE" value=":memory:"/>
```

### "Aprendiz no sabe usar Git"

Es esperado en mayo (Git formal viene en GA7-AA1, junio). Plan:

- Sesión Discord extra primera semana: instalar Git, fork, clone, commit, push
- Cheatsheet pinneado en Discord
- "Acompañamiento" para los 5-10 más rezagados

## Mantenimiento

Cuando agregues evidencias futuras (GA6-AA2, GA7-AA1, etc.):

1. Crea `evidencias/{evidencia-id}/README.md` con el patrón de GA6-AA1
2. Crea `tests/Feature/Evidencias/{Evidencia}Test.php` con tests Pest
3. Agrega un job `autograde-{evidencia-id}` a `.github/workflows/autograde.yml`
4. Actualiza la tabla en `README.md` principal
5. Push al template — aprendices que ya tengan su fork pueden hacer:
   ```bash
   git remote add upstream {url-template}
   git fetch upstream
   git merge upstream/main
   ```
