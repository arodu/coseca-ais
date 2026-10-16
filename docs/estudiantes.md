# Estudiantes

**Propósito:** Modela la matrícula de un estudiante en un programa y ubicación,
su tipología y su ciclo de vida dentro del sistema.

**Entidades principales:** Student, StudentData, StudentCourse, StudentDocument,
InterestArea.

---

## Descripción general

Un `Student` representa la matrícula de una persona en un **tenant** (ubicación ×
programa) durante un **lapso**, vinculada a un usuario de acceso (`AppUser`). Un
mismo usuario puede tener varias matrículas a lo largo del tiempo (por ejemplo,
al cambiar de programa), aunque solo una activa.

## Tipos de estudiante

| Tipo (clave) | Etiqueta      | Recorrido                     |
| ------------ | ------------- | ----------------------------- |
| `regular`    | Regular       | Flujo completo de seis etapas |
| `validated`  | Convalidación | Solo Registro y Convalidación |
| `history`    | Histórico     | Solo Registro y Convalidación |

El tipo se define al crear al estudiante y por defecto es `regular`.

## Datos del estudiante

La información personal y académica vive en `StudentData` (relación uno a uno):

- Datos de contacto: teléfono y dirección.
- Género (`F`/`M`).
- Semestre actual y unidades de crédito aprobadas.
- Área de interés (`InterestArea`).
- Observaciones y total de horas.

## Ciclo de vida

- **Alta automática:** al crear un usuario con rol `student` se crea una
  matrícula `regular` en su primer tenant. Al crear una matrícula se genera
  automáticamente la etapa de Registro.
- **Cambio de programa:** se desactiva la matrícula anterior y se crea una nueva
  `regular` para el nuevo tenant.
- **Desactivación/reactivación:** la matrícula puede desactivarse y reactivarse
  sin eliminarla.

## Niveles académicos

Los niveles disponibles se derivan del régimen del programa (`ProgramRegime`):
semestral, trimestral, anualizado de 5 años o anualizado de 6 años. Cada régimen
define su nivel máximo y el sistema calcula el rango de niveles ofrecidos a
partir de él.

## Notas

- `StudentDocument` es un registro polimórfico de documentos generados; el
  enumerado `DocumentType` existe pero actualmente no se utiliza (el tipo se
  guarda como texto libre).

## Relaciones con otros dominios

| Dominio | Relación                                                  |
| ------- | --------------------------------------------------------- |
| Proceso | Cada estudiante tiene su pipeline de etapas               |
| Tenants | La matrícula pertenece a un tenant                        |
| Roles   | El rol `student` accede al portal con su matrícula activa |

## Archivos de código relevantes

- `src/Model/Entity/Student.php` — entidad y atributos derivados.
- `src/Model/Table/StudentsTable.php` — asociaciones, validaciones y totales de horas.
- `src/Model/Field/StudentType.php` — tipos de estudiante.
- `src/Model/Entity/StudentData.php` — datos personales y académicos.
- `src/Utility/StudentLevels.php` — cálculo de niveles académicos.
