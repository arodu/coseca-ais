<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Model\Field\UserRole;
use App\Test\Factory\AppUserFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\AppUsersController Test Case
 *
 * Pruebas para el controlador `AppUsersController`
 *
 * @uses \App\Controller\Admin\AppUsersController
 */
class AppUsersControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Prueba de funcionalidad para obtener la vista y que en ella existan los datos correspondientes en el AppUsersController
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::index()
     */
    public function testIndex(): void
    {
        // Configuracion inicial
        $this->get('/admin/app-users');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/app-users'); // Carga la ruta correspondiente
        $this->assertResponseCode(200);

        // Ejecucion de acciones
        $user = AppUserFactory::make(['role' => UserRole::ADMIN->value])
            ->with('TenantFilters', ['tenant_id' => $this->tenant_id])
            ->persist();
        $this->get('/admin/app-users');
        $this->assertResponseCode(200);

        // Verificación de resultados
        $this->assertResponseContains($user->email); //Verifica que el email de usuario exista en la vista
        $this->assertResponseContains($user->first_name); //Verifica que el apellido de usuario exista en la vista
        $this->assertResponseContains($user->dni); //Verifica que la cedula de usuario exista en la vista
    }

    /**
     * Prueba de funcionalidad para obtener la vista detalle de un AppUser
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::view()
     */
    public function testView(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Ejecucion de acciones
        $user = $this->createUserWithAdminRole(); // Crea un usuario con Rol Administrador

        // Verificación de resultados
        $this->get('/admin/app-users/view/' . $user->id); // Carga la vista correspondiente con el ID de usuario creado
        $this->assertResponseCode(200);

        $this->assertResponseContains($user->email); //Verifica que el email de usuario exista en la vista
        $this->assertResponseContains($user->first_name); //Verifica que el apellido de usuario exista en la vista
        $this->assertResponseContains($user->dni); //Verifica que la cedula de usuario exista en la vista
    }
}
