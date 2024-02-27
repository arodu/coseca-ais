<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Model\Field\UserRole;
use Cake\I18n\FrozenDate;
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
        $user = $this->createUserWithAdminRole(); //Crea un usuario
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

    /**
     * Prueba de funcionalidad para actualizar la vista detalle de un AppUser
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::add()
     */
    public function testAdd(): void
    {
        // Configuracion inicial
        $this->get('/admin/app-users/add');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/app-users/add'); //Carga la vista correspondiente al formulario.
        $this->assertResponseCode(200);

        // Ejecucion de acciones
        $this->post('/admin/app-users/add', [
            'username' => 'Username test',
            'email' => 'email@test.aiscoseca',
            'dni' => '12345678',
            'first_name' => 'FirstName test',
            'last_name' => 'LastName test',
            'active' => true,
            'role' => UserRole::ADMIN->value,
            'created' => FrozenDate::now(),
            'modified' => FrozenDate::now(),
        ]); // Envio de datos de prueba en el formulario

        // Verificación de resultados
        $this->assertResponseContains('Username test'); //Verifica que el username de usuario exista en la vista
        $this->assertResponseContains('email@test.aiscoseca'); //Verifica que el email de usuario exista en la vista
        $this->assertResponseContains('12345678'); //Verifica que la cedula de usuario exista en la vista
        $this->assertResponseContains('FirstName test'); //Verifica que el nombre de usuario exista en la vista
        $this->assertResponseContains('LastName test'); //Verifica que el apellido de usuario exista en la vista
    }

    /**
     * Prueba de funcionalidad para cargar la vista detalle edicion de un AppUser
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $user = $this->createUserWithAdminRole(); // Crea un usuario con Rol Administrador

        $this->get('/admin/app-users/edit/' . $user->id); // Carga la vista correspondiente con el ID del registro creado
        $this->assertResponseCode(200);

        // Envio de datos de prueba para actualizar el registro
        $this->post('/admin/app-users/edit/' . $user->id, [
            'username' => 'Test edit username',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/app-users/edit/' . $user->id); // Carga la vista correspondiente con el ID del registro creado

        // Verificación de resultados
        $this->assertResponseContains('Test edit username'); //Verifica que exista la informacion actualizada
        $this->assertResponseNotContains($user->username); //Verifica que no exista la informacion anterior en el registro
    }

    /**
     * Prueba de funcionalidad para elimnar un AppUser
     *
     * @return void
     * @uses \App\Controller\Admin\AppUsersController::delete()
     */
    public function testDelete(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $user = $this->createUserWithAdminRole(); // Crea un usuario con Rol Administrador
        $this->delete('/admin/app-users/edit/' . $user->id); // Envio del ID de usuario que se eliminara

        // Verificación de resultados
        $res = $this->getRecordExists('Users', $user->id); // Verificar que el rgistro exista en Base de datos
        $this->assertTrue($res); // Confirmacion de la consulta
    }
}
