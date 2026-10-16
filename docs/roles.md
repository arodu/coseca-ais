# Roles y acceso

**Propósito:** Define los roles del sistema, sus agrupaciones y qué áreas puede
utilizar cada uno.

**Entidades principales:** AppUser, TenantFilter.

---

## Roles

| Rol (clave) | Etiqueta        | Descripción                                          |
| ----------- | --------------- | ---------------------------------------------------- |
| `root`      | Root            | Acceso total al sistema y a la configuración         |
| `manager`   | Manager         | Gestión de catálogos y supervisión general           |
| `admin`     | Admin           | Administración de estudiantes y etapas por ubicación |
| `assistant` | Asistente       | Perfil de personal de apoyo                          |
| `tutor`     | Tutor académico | Tutor que acompaña al estudiante                     |
| `student`   | Estudiante      | Acceso al portal del estudiante                      |

## Agrupaciones

Los roles se agrupan para evaluar permisos (`UserRole::group()`):

| Grupo     | Roles incluidos                 |
| --------- | ------------------------------- |
| `student` | student                         |
| `staff`   | assistant, admin, root, manager |
| `admin`   | admin, manager, root            |
| `tutor`   | tutor, admin, manager, root     |
| `manager` | manager, root                   |
| `root`    | root                            |

## Permisos por área

Las reglas se definen en `config/permissions.php` y se evalúan de arriba hacia
abajo (gana la primera coincidencia):

| Área                      | Ruta       | Grupos con acceso            |
| ------------------------- | ---------- | ---------------------------- |
| Autenticación y registro  | `/`        | Público                      |
| Portal del estudiante     | `/student` | student                      |
| Administración            | `/admin`   | admin (admin, manager, root) |
| Gestión de catálogos      | `/manager` | manager (manager, root)      |
| Sistema (geo/ubicaciones) | —          | Todos los roles              |

> **Nota:** los roles `assistant` y `tutor` están definidos pero no tienen
> prefijo de acceso asignado en `config/permissions.php`; actualmente solo
> acceden a acciones de perfil.

## Portales y rutas

| Prefijo    | Área                                   | Acceso               |
| ---------- | -------------------------------------- | -------------------- |
| `/`        | Inicio y autenticación                 | Público              |
| `/student` | Portal del estudiante                  | student              |
| `/admin`   | Administración de estudiantes y etapas | admin, manager, root |
| `/manager` | Gestión de catálogos y configuración   | manager, root        |

Bajo el área de administración existe el sub-prefijo `/admin/stage` para las
operaciones sobre cada etapa del proceso. Las imágenes cargadas se sirven desde
`/uploads` a través de Glide.

## Autenticación

Se apoya en el plugin CakeDC/Users: inicio de sesión local, inicio de sesión
social y reCAPTCHA en el registro. Las políticas de autorización
(`src/Policy/`) complementan la matriz de permisos con reglas por recurso.

## Archivos de código relevantes

- `config/permissions.php` — matriz de roles/permissions por prefijo.
- `config/users.php` — configuración de CakeDC/Users.
- `src/Model/Field/UserRole.php` — roles y agrupaciones.
- `src/Policy/` — políticas de autorización por recurso.
- `config/routes.php` — definición de prefijos y rutas.
