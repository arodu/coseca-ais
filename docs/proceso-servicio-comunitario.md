# Proceso de servicio comunitario

**Propósito:** Modela el recorrido de un estudiante por las etapas del servicio
comunitario y las reglas que habilitan el avance entre ellas.

**Entidades principales:** Student, StudentStage, StudentAdscription,
StudentTracking, StudentCourse, Lapse, LapseDate.

---

## Descripción general

El proceso se organiza en una secuencia de **etapas** (`StudentStage`). El
estudiante avanza de una etapa a la siguiente a medida que cada una se cierra en
estado `success`. El flujo concreto depende del tipo de estudiante y se define en
`config/stages.php`.

Cada estudiante tiene una fila por etapa en `student_stages`, con la restricción
de que la combinación `(student_id, stage)` es única.

## Etapas

| Etapa (clave) | Etiqueta      | Estado por defecto | Al cerrar |
| ------------- | ------------- | ------------------ | --------- |
| `register`    | Registro      | `in-progress`      | `review`  |
| `course`      | Taller        | `waiting`          | `success` |
| `adscription` | Adscripción   | `waiting`          | `success` |
| `tracking`    | Seguimiento   | `in-progress`      | `review`  |
| `results`     | Resultados    | `in-progress`      | `review`  |
| `ending`      | Conclusión    | `waiting`          | `review`  |
| `validation`  | Convalidación | `waiting`          | `review`  |

## Grupos de etapas por tipo de estudiante

| Tipo de estudiante | Etapas                                                             |
| ------------------ | ------------------------------------------------------------------ |
| `regular`          | Registro, Taller, Adscripción, Seguimiento, Resultados, Conclusión |
| `validated`        | Registro, Convalidación                                            |
| `history`          | Registro, Convalidación                                            |

## Estados de etapa

Los estados posibles (`StageStatus`) son: `waiting` (en espera),
`in-progress` (en proceso), `review` (en revisión), `success` (realizado),
`failed` (fallido) y `locked` (bloqueado).

## Transiciones

- Una etapa solo avanza a la siguiente cuando se cierra en estado `success`, o
  bien cuando un administrador fuerza el cierre.
- El cierre de una etapa y la creación de la siguiente ocurren en una única
  transacción; la creación es idempotente (no duplica etapas existentes).
- Los administradores pueden forzar el cierre de la etapa actual desde
  `Admin/StudentStagesController`.

## Reglas de negocio

1. **Horas mínimas:** el cierre y la validación de la etapa de Seguimiento
   requieren que las horas acumuladas alcancen el mínimo configurado
   (`coseca.hours-min`, por defecto 120 horas).
2. **Sin adscripciones abiertas:** el Seguimiento tampoco se cierra ni se valida
   mientras existan adscripciones en estado `pending` u `open`.
3. **Adscripción principal:** la primera adscripción de un estudiante se marca
   automáticamente como `principal`; al definir una nueva se desmarca la
   anterior. La etapa de Conclusión exige que el estudiante tenga una
   adscripción principal.
4. **Apertura de adscripción:** al pasar una adscripción a estado `open` se
   cierra la etapa de Adscripción.
5. **Cierre de Seguimiento:** al cerrar la etapa de Seguimiento, todas las
   adscripciones en `pending` u `open` pasan a `closed`.
6. **Validación de adscripción:** el estado `validated` solo puede asignarlo
   quien tenga permiso de validación.
7. **Acumulación de horas:** las horas registradas en el Seguimiento se suman al
   total del estudiante y alimentan el porcentaje de avance.

## Documentos

La emisión de documentos se realiza en formatos PDF:

| Formato | Documento                        | Condición                                      |
| ------- | -------------------------------- | ---------------------------------------------- |
| 002     | Constancia del Taller            | No aplica si el estudiante está exonerado      |
| 007     | Lista de adscripción/seguimiento | Solo adscripciones `closed` o `validated`      |
| 008     | Seguimiento y adscripción        | Adscripción principal con datos de institución |
| 009     | Conclusión                       | Etapa de Conclusión                            |

La emisión de **007** y **008** requiere que la etapa de Seguimiento esté en
`review` o `success` (cerrada) y que el estudiante no tenga adscripciones
abiertas; ver `StudentStagePolicy::canPrint()`
(`src/Policy/StudentStagePolicy.php:163`). Por eso no se activan mientras el
seguimiento esté en curso.

## Relaciones con otros dominios

| Dominio     | Relación                                                      |
| ----------- | ------------------------------------------------------------- |
| Estudiantes | El proceso pertenece a un estudiante; depende de su tipo      |
| Tenants     | El flujo se acota por el tenant (ubicación × programa)        |
| Roles       | Cada transición valida permisos vía políticas de autorización |

## Archivos de código relevantes

- `config/stages.php` — definición de etapas y grupos por tipo de estudiante.
- `src/Utility/Stages.php` — listado y avance de etapas.
- `src/Model/Table/StudentStagesTable.php` — motor de transiciones.
- `src/Policy/StudentStagePolicy.php` — reglas de cierre, validación e impresión.
- `src/Controller/Traits/Stage/` — lógica de cada etapa (registro, taller, adscripción, seguimiento).
- `src/Controller/Admin/Stage/` — controladores de administración de etapas.
