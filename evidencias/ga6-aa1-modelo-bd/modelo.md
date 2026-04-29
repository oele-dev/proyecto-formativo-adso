# Modelo de base de datos — Proyecto formativo

> **Aprendiz:** {TODO: tu nombre completo}
> **Ficha:** {TODO: 3235898 o 3235899}
> **Proyecto:** {TODO: nombre corto de tu proyecto}

## 1. Contexto del proyecto

{TODO: 1 párrafo sobre qué resuelve tu software, quién lo usa, qué información maneja}

## 2. Entidades identificadas

| # | Entidad | Descripción | Atributos clave |
|---|---------|-------------|-----------------|
| 1 | {TODO} | {TODO} | {TODO} |
| 2 | {TODO} | {TODO} | {TODO} |
| 3 | {TODO} | {TODO} | {TODO} |
| 4 | {TODO} | {TODO} | {TODO} |
| 5 | {TODO} | {TODO} | {TODO} |

## 3. Diagrama entidad-relación

```mermaid
erDiagram
    {TODO_ENTIDAD_1} ||--o{ {TODO_ENTIDAD_2} : "{relación}"
    {TODO_ENTIDAD_1} {
        bigint id PK
        string nombre
        timestamp created_at
        timestamp updated_at
    }
    {TODO_ENTIDAD_2} {
        bigint id PK
        bigint entidad_1_id FK
        timestamp created_at
        timestamp updated_at
    }
```

> 💡 Reemplaza el ejemplo arriba con tu modelo real. Mermaid se renderiza automáticamente en GitHub.

## 4. Justificación de la normalización

### 1FN (Primera Forma Normal)

{TODO: explica cómo aseguraste que cada celda tenga un solo valor (atómico) y no haya grupos repetidos}

### 2FN (Segunda Forma Normal)

{TODO: explica cómo eliminaste dependencias parciales. Si tienes claves compuestas, justifica}

### 3FN (Tercera Forma Normal)

{TODO: explica cómo eliminaste dependencias transitivas — atributos que dependen de otros no-clave}

### Decisiones de denormalización (si aplica)

{TODO: si decidiste denormalizar algo por rendimiento, justifica aquí. Si no, escribe "ninguna"}

## 5. Restricciones de integridad

| Tabla | Restricción | Tipo | Justificación |
|-------|-------------|------|---------------|
| {TODO} | {TODO: ej. email UNIQUE} | UNIQUE | {TODO: por qué} |
| {TODO} | {TODO: ej. precio > 0} | CHECK | {TODO: regla de negocio} |
| {TODO} | {TODO: FK a tabla X} | FK | {TODO: integridad referencial} |

## 6. Trazabilidad con requisitos

> Conecta cada entidad con los requisitos funcionales que documentaste en GA4.

| Entidad | Requisito de GA4 | Justificación |
|---------|-------------------|---------------|
| {TODO} | RF-{TODO} | {TODO} |
| {TODO} | RF-{TODO} | {TODO} |

## 7. Bibliografía / referencias

- {TODO: si consultaste algún recurso adicional}
