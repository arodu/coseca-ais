# AGENTS.md

## Project

COSECA AIS: CakePHP 4.5 app (PHP 8.1) tracking community-service (servicio comunitario)
workflow at UNERG. Spanish-language domain. MySQL 8.0. Runs via **DDEV** (Docker), docroot `webroot/`.

## Commands

All PHP/composer/cake commands run **inside the DDEV container** (`ddev ssh`, or prefix `ddev exec`).

- Start / enter: `ddev start`, then `ddev ssh`
- Install deps: `composer install` (post-install hook auto-runs `cache clear_all`, `backup_db`, migrations)
- AdminLTE frontend assets: `bin/cake cakelte install` (copies to `webroot/adminlte`, gitignored)
- Apply DB schema: `bin/cake migrations migrate`
- Full reset + test data: `composer reset-factory-faker` (rollback all, migrate, seed `TestingSeed`)
- Tests: `composer test` (full phpunit). Single test / filter:
  `vendor/bin/phpunit tests/TestCase/Controller/Admin/StudentsControllerTest.php` or `--filter testName`
- Lint: `composer cs-check` (phpcs); auto-fix `composer cs-fix`
- Static analysis: `composer stan` (PHPStan level 8)
- Everything: `composer check` (= `test` then `cs-check`)

## CI

`.github/workflows/ci.yml` runs on push to `main`/`develop`: PHP 8.1 + MySQL 8.0,
then `vendor/bin/phpunit` and `composer cs-check`. PHPStan is present but commented out in CI.

## Testing notes

- DB connection is provided only by DDEV env (`DATABASE_URL` / `DATABASE_TEST_URL` -> MySQL `test` DB;
  the `.ddev` post-start hook creates it). Run tests inside DDEV, not on the host.
- `tests/bootstrap.php` builds the test schema via `Migrations\TestSuite\Migrator`; data comes from
  fixture factories (`vierge-noire/cakephp-fixture-factories`) in `tests/Factory/`.
- Controller tests extend `tests/TestCase/Controller/Admin/AdminTestCase.php` or `.../Student/StudentTestCase.php`
  (they enable CSRF/security tokens and build a complete tenant/student fixture graph).
- Plugins have their own test suites/config (`plugins/*/phpunit.xml.dist`); the root `phpunit.xml.dist`
  also includes them via the `plugins` suite. Focused plugin run: `vendor/bin/phpunit -c plugins/Manager/phpunit.xml.dist`.

## Architecture

- `App\` -> `src/`. Local custom plugins: `Manager` (routes under `/manager`) and `System`;
  each has its own `composer.json`/`phpunit.xml.dist`. `ModalForm` is a vendor package, not in `plugins/`.
- Auth: CakeDC/Users. Roles in `App\Model\Field\UserRole` (groups root/manager/admin/student);
  authorization rules in `config/permissions.php`.
- Routing (`config/routes.php`): `DashedRoute`; prefixes `Admin`, `Admin/Stage`, `Student`; Glide image
  middleware serves `/uploads` from `files/`.
- Workflow stages are config-driven in `config/stages.php` (`Stages`, `StageGroups`).
- Multi-tenant filtering via `App\Utility\FilterTenantUtility` + `TenantFilters` table.
- UI uses CakeLte/AdminLTE theme; printable/PDF formats live in `templates/Documents/format*.php`
  (CakePdf/DomPdf).

## Conventions / gotchas

- PHP files use `declare(strict_types=1)`.
- phpcs covers only `src/` and `tests/`; PHPStan covers only `src/`. `templates/` and `plugins/` are not linted.
- Never commit `config/app_local.php`, `config/.env`, `webroot/adminlte`, or generated files under `files/`
  (all gitignored).
