# Esquema de seguridad de la base de datos

> **Evidencia:** GA6-AA1 — Modelo BD del proyecto
> **Aprendiz:** {TODO: tu nombre}

## 1. Roles del sistema

| Rol | Permisos | Tablas a las que accede |
|-----|----------|--------------------------|
| Administrador | CRUD completo | Todas |
| {TODO} | {TODO} | {TODO} |
| {TODO} | {TODO} | {TODO} |

## 2. Información sensible

| Tabla | Columna | Tipo de sensibilidad | Tratamiento |
|-------|---------|---------------------|-------------|
| users | password | Crítica | Hash bcrypt (Laravel `Hash::make`) |
| {TODO} | {TODO} | {TODO} | {TODO: ej. encriptado, hash, restringido por rol} |

## 3. Auditoría

### Timestamps

Todas las tablas tienen `created_at` y `updated_at` (vía `$table->timestamps()` en migración).

### Soft deletes

Las tablas {TODO: lista las tablas} usan `softDeletes()` para preservar histórico.

### Trazabilidad de cambios (opcional)

{TODO: si implementaste columnas `created_by`, `updated_by`, o paquete de auditoría, descríbelo}

## 4. Integridad referencial

- Todas las FK están definidas con `foreignId(...)->constrained()`.
- Política de eliminación:
  - **`onDelete('cascade')`**: aplica a {TODO: ej. detalles de pedidos cuando se borra el pedido}
  - **`onDelete('restrict')`** (default): aplica a {TODO: ej. categorías que tienen productos}
  - **`onDelete('set null')`**: aplica a {TODO}

## 5. Validaciones a nivel de aplicación

Aunque la BD tenga restricciones, también validamos en Laravel:

```php
// Ejemplo de FormRequest
'email' => 'required|email|unique:users,email',
'precio' => 'required|numeric|min:0',
```

{TODO: lista las validaciones más importantes de tu dominio}

## 6. Backup y restauración

{TODO: describe cómo se respaldaría la BD en producción — incluso si es solo plan, no implementado}

- **Frecuencia:** {TODO: diaria/semanal}
- **Tipo:** {TODO: full/incremental}
- **Almacenamiento:** {TODO: dónde}
- **Retención:** {TODO: cuántos días}

## 7. Cumplimiento normativo (si aplica)

{TODO: si tu proyecto maneja datos personales, menciona Habeas Data (Ley 1581/2012 Colombia) y cómo lo cumples. Si no aplica, escribe "no aplica al alcance del proyecto".}
