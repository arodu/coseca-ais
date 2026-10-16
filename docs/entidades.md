# Entidades

**Propósito:** Inventario del modelo de datos de COSECA AIS y las relaciones
entre sus entidades principales.

**Entidades principales:** Tenant, Student, StudentStage, StudentAdscription,
Institution, Tutor, Lapse, Program.

---

## Jerarquía principal

```
Tenant (ubicación × programa)
├── Lapse ──< LapseDate
├── Student ──┬── StudentData            (1:1)
│             ├── StudentStage           (pipeline de etapas)
│             ├── StudentAdscription ──┬── StudentTracking
│             │                        └── StudentDocument (polimórfico)
│             └── StudentCourse
├── Institution ──< InstitutionProject ──< StudentAdscription
└── Tutor ──< StudentAdscription

Program ──< Tenant          Location ──< Tenant
Area ──< Program ──< InterestArea
Tenant ──< TenantFilter >── AppUser
```

## Entidades

| Entidad            | Qué modela                                         | Relaciones clave                                                   |
| ------------------ | -------------------------------------------------- | ------------------------------------------------------------------ |
| Tenant             | Ubicación × programa                               | Tiene muchos Lapses, Students, Institutions, Tutors                |
| Student            | Matrícula de un estudiante en un tenant y lapso    | Pertenece a AppUser y Tenant; tiene etapas, adscripciones y cursos |
| StudentData        | Datos personales y académicos del estudiante       | Pertenece a Student y InterestArea                                 |
| StudentStage       | Etapa del proceso para un estudiante               | Pertenece a Student                                                |
| StudentAdscription | Adscripción a un proyecto de institución con tutor | Pertenece a Student, InstitutionProject y Tutor                    |
| StudentTracking    | Registro de horas de servicio                      | Pertenece a StudentAdscription                                     |
| StudentCourse      | Registro del taller (etapa de Taller)              | Pertenece a Student                                                |
| StudentDocument    | Documento generado asociado a un estudiante        | Pertenece a Student (y a un registro de origen)                    |
| Institution        | Institución de la comunidad con datos de contacto  | Pertenece a Tenant; tiene proyectos                                |
| InstitutionProject | Proyecto o actividad ofrecida por una institución  | Pertenece a Institution e InterestArea                             |
| Tutor              | Tutor que acompaña al estudiante                   | Pertenece a Tenant; tiene adscripciones                            |
| Location           | Sede, núcleo o extensión de la universidad         | Tiene muchos Tenants                                               |
| Program            | Programa académico con régimen y créditos          | Pertenece a Area; tiene Tenants e InterestAreas                    |
| Area               | Área o facultad que agrupa programas               | Tiene muchos Programs                                              |
| InterestArea       | Área de interés de investigación o trabajo         | Pertenece a Program                                                |
| Lapse              | Lapso académico de un tenant                       | Pertenece a Tenant; tiene LapseDates                               |
| LapseDate          | Ventana de fechas por etapa dentro de un lapso     | Pertenece a Lapse                                                  |
| TenantFilter       | Asignación de un tenant a un usuario de personal   | Pertenece a AppUser y Tenant                                       |
| AppUser            | Usuario de acceso (identidad)                      | Tiene matrículas y filtros de tenant                               |

## Autoría y eliminación lógica

Las entidades principales usan marcas de tiempo y autoría automática
(`created_by`/`modified_by`). Algunas entidades (`Area`, `Program`) usan borrado
lógico.

## Archivos de código relevantes

- `src/Model/Entity/` — entidades y atributos derivados.
- `src/Model/Table/` — asociaciones, validaciones y consultas.
- `config/schema/` y `config/Migrations/` — esquema y migraciones.
