# Tenants

**Propósito:** Define el modelo multi-tenant que separa los datos por ubicación
y programa, y cómo se filtran los registros según el usuario.

**Entidades principales:** Tenant, TenantFilter, Location, Program.

---

## Descripción general

Un **tenant** es la combinación de una **ubicación** (`Location`, es decir una
sede, núcleo o extensión de la universidad) y un **programa** (`Program`). La
combinación `(location_id, program_id)` es única.

El tenant es la frontera de alcance de los datos: estudiantes, lapsos,
instituciones, tutores y filtros de usuario pertenecen a un tenant.

## Control de acceso por usuario

La tabla `TenantFilter` asocia usuarios de personal con los tenants que pueden
ver. Un usuario puede tener uno o varios tenants asignados.

Al iniciar sesión, el sistema resuelve los tenants del usuario y los guarda en
sesión:

| Usuario         | Tenants asignados                     |
| --------------- | ------------------------------------- |
| root            | Todos los tenants                     |
| student         | El tenant de su matrícula activa      |
| manager y admin | Los registrados en sus `TenantFilter` |

## Filtrado de datos

El comportamiento `FilterTenantBehavior` aplica el filtro de tenant en las
consultas (`tenant_id IN <tenants de sesión>`) para las tablas que lo declaran:
estudiantes, lapsos, tenants (por `id`), instituciones y filtros de tenant. El
filtro puede omitirse de forma explícita cuando se requiere ver un conjunto más
amplio.

## Gestión

La asignación de tenants a usuarios se administra en el área de administración
(`TenantsController`). El plugin **Manager** opera intencionalmente sin filtro de
tenant, ya que gestiona los catálogos globales (áreas, programas, ubicaciones,
tenants y usuarios).

## Relaciones con otros dominios

| Dominio     | Relación                                               |
| ----------- | ------------------------------------------------------ |
| Estudiantes | Cada matrícula pertenece a un tenant                   |
| Proceso     | El flujo del proceso se acota por tenant               |
| Roles       | El alcance de datos de cada rol depende de sus tenants |

## Archivos de código relevantes

- `src/Model/Entity/Tenant.php` y `src/Model/Table/TenantsTable.php`.
- `src/Model/Table/TenantFiltersTable.php` — asignación usuario ↔ tenant.
- `src/Utility/FilterTenantUtility.php` — resolución y sesión de tenants.
- `src/Model/Behavior/FilterTenantBehavior.php` — filtrado de consultas.
- `src/Event/UsersListener.php` — actualización del filtro al iniciar sesión.
