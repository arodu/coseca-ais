# COSECA AIS

[![CI](https://github.com/arodu/coseca-ais/actions/workflows/ci.yml/badge.svg)](https://github.com/arodu/coseca-ais/actions/workflows/ci.yml)
[![License: GPL v3](https://img.shields.io/badge/license-GPLv3-blue.svg)](https://www.gnu.org/licenses/gpl-3.0)
[![PHP 8.4](https://img.shields.io/badge/PHP-8.4-777bb4.svg)](https://www.php.net/)
[![CakePHP 4.5](https://img.shields.io/badge/CakePHP-4.5-d33c43.svg)](https://cakephp.org/)

> Sistema de gestión y control del seguimiento del Servicio Comunitario del Área
> de Ingeniería de Sistemas de la Universidad Nacional Experimental Rómulo
> Gallegos ([UNERG](https://unerg.edu.ve)).

COSECA AIS es una aplicación web que digitaliza el proceso de servicio
comunitario del estudiante, desde el registro hasta la conclusión de su
expediente, con acceso segmentado por roles y por ubicación. El detalle del
proceso y las reglas de negocio están en la [documentación](docs/index.md).

## Características

- Expediente digital del estudiante a lo largo de todas las etapas.
- Flujo de etapas configurable y estados por etapa.
- Filtrado multi-tenant por ubicación y programa.
- Portal del estudiante para registro, seguimiento y consulta de su avance.
- Administración de ubicaciones, instituciones, tutores y lapsos.
- Generación de documentos y reportes en PDF.

## Tecnología

| Componente    | Tecnología                              |
| ------------- | --------------------------------------- |
| Lenguaje      | PHP 8.4                                 |
| Framework     | CakePHP 4.5                             |
| Base de datos | MySQL 8.0                               |
| Interfaz      | CakeLte (AdminLTE) sobre Bootstrap      |
| Autenticación | CakeDC/Users (roles, OAuth y reCAPTCHA) |
| Documentos    | CakePdf / Dompdf                        |
| Entorno local | DDEV (Docker)                           |

## Requisitos

- [PHP 8.4](https://www.php.net/) o superior.
- [Composer](https://getcomposer.org/).
- [DDEV](https://ddev.readthedocs.io/).
- [Docker](https://www.docker.com/get-started/).
- [Git](https://git-scm.com/).

## Instalación

1. Haga un [fork](https://github.com/arodu/coseca-ais) del repositorio y clónelo
   en su equipo:

   ```bash
   git clone https://github.com/your_username/coseca-ais.git
   ```

2. Inicie el entorno con DDEV desde la carpeta del proyecto:

   ```bash
   ddev start
   ```

3. Ingrese al contenedor:

   ```bash
   ddev ssh
   ```

4. Instale las dependencias de PHP:

   ```bash
   composer install
   ```

5. Compile los recursos del tema (AdminLTE):

   ```bash
   bin/cake cakelte install
   ```

6. Aplique el esquema de base de datos y cargue los datos:

   ```bash
   bin/cake migrations migrate
   bin/cake migrations seed --seed BasicSeed
   ```

> [!IMPORTANT]
> Todos los comandos de PHP, Composer y CakePHP deben ejecutarse **dentro del
> contenedor** (`ddev ssh` o con el prefijo `ddev exec`).

7. Acceda a la URL que DDEV mostró al ejecutar `ddev start` (por defecto,
   `https://coseca-ais.ddev.site`).

## Configuración

La configuración específica del entorno vive en `config/app_local.php`, que no
se versiona. Tome como base `config/app_local.example.php`.

- **`SECURITY_SALT`**: defina una sal única para cada entorno.
- **reCAPTCHA**: el registro de estudiantes usa reCAPTCHA
  (`RECAPTCHA_CLIENT_KEY` y `RECAPTCHA_CLIENT_SECRET`).
- **Correo**: en desarrollo, los mensajes se capturan localmente con Mailpit en
  `https://coseca-ais.ddev.site:8026`; no se envían a Internet.

## Datos de prueba

El seed `TestingSeed` genera un conjunto completo de datos para desarrollo
(ubicaciones, instituciones, tutores y estudiantes):

```bash
composer reset-factory-faker
```

> [!NOTE]
> `reset-factory-faker` elimina los datos existentes, aplica las migraciones y
> carga los datos de prueba. Úselo solo en entornos de desarrollo.

Los usuarios de prueba (contraseña `1234`) incluyen `root@example.com`,
`manager@example.com` y administradores por cada ubicación.

## Desarrollo

Los comandos principales se ejecutan dentro del contenedor DDEV:

| Comando             | Descripción                             |
| ------------------- | --------------------------------------- |
| `composer test`     | Ejecuta la suite completa de PHPUnit    |
| `composer cs-check` | Verifica el estilo de código (PHPCS)    |
| `composer cs-fix`   | Corrige automáticamente el estilo       |
| `composer stan`     | Análisis estático con PHPStan (nivel 8) |
| `composer check`    | Ejecuta `test` y `cs-check`             |

Para ejecutar una prueba puntual:

```bash
vendor/bin/phpunit tests/TestCase/Controller/Admin/StudentsControllerTest.php
vendor/bin/phpunit --filter testName
```

La integración continua (`.github/workflows/ci.yml`) corre PHPUnit y PHPCS sobre
PHP 8.4 y MySQL 8.0 en cada push a `main` o `develop` y en cada pull request.

## Documentación

La documentación de dominio está en [`docs/`](docs/index.md):

| Documento                                                               | Contenido                          |
| ----------------------------------------------------------------------- | ---------------------------------- |
| [Proceso de servicio comunitario](docs/proceso-servicio-comunitario.md) | Etapas, estados y reglas           |
| [Estudiantes](docs/estudiantes.md)                                      | Tipos y ciclo de vida              |
| [Roles y acceso](docs/roles.md)                                         | Roles, permisos y rutas            |
| [Tenants](docs/tenants.md)                                              | Multi-tenant: ubicación × programa |
| [Entidades](docs/entidades.md)                                          | Modelo de datos                    |

## Estructura del proyecto

```
coseca-ais/
├── config/          Configuración, rutas, permisos, migraciones y seeds
├── plugins/         Plugins locales: Manager, System y ModalForm
├── src/             Código de la aplicación (controladores, modelos, utilidades)
├── templates/       Vistas y formatos de documentos/PDF
├── tests/           Pruebas de PHPUnit y factorías de fixtures
├── webroot/         Punto de entrada y recursos públicos
└── docs/            Documentación de dominio
```

## Contribución

Las contribuciones son bienvenidas:

1. Haga un fork del repositorio y cree una rama descriptiva.
2. Implemente el cambio siguiendo el estilo existente.
3. Asegúrese de que `composer check` pase sin errores.
4. Abra un pull request describiendo el problema y la solución.

## Licencia

COSECA AIS se distribuye bajo la **GNU General Public License v3.0**. Consulte el
archivo [LICENSE](LICENSE) para más detalles.

Al ser software libre, cualquier trabajo derivado debe mantenerse también bajo
esta licencia, garantizando que las mejoras vuelvan a la comunidad y a la
institución.
