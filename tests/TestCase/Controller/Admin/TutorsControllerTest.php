<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\TutorFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * Pruebas para el controlador `TutorsController`
 *
 * @uses \App\Controller\Admin\TutorsController
 */
class TutorsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Prueba de funcionalidad de cargar la vista de los Tutores registrados
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::index()
     */
    public function testIndex(): void
    {
        // Configuracion inicial
        $this->get('/admin/tutors');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/tutors'); //Cargar la vista index de Tutores
        $this->assertResponseCode(200);

        // Verificacion de acciones
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id,
            'name' => 'Tutor de prueba',
            'dni' => 12345678,
            'phone' => 00001234567,
            'email' => 'email@test.com'
        ])->persist(); //Creamos un nuevo tutor de prueba

        // Verificacion de resultados
        $this->get('/admin/tutors'); //Cargar nuevamente la vista de todos los Tutores
        $this->assertResponseContains($tutor->name); //Verificamos que en la vista exista el nombre del tutor creado.
        $this->assertResponseContains($tutor->dni);  //Verificamos que en la vista exista la cedula del tutor creado.
        $this->assertResponseContains($tutor->phone); //Verificamos que en la vista exista el telefono del tutor creado.
        $this->assertResponseContains($tutor->email); //Verificamos que en la vista exista el email del tutor creado.
    }

    /**
     * Prueba de funcinonalidad de ver vista detalle de un Tutor creado
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::view()
     */
    public function testView(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Cremos un Tutor de prueba
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/tutors/view/' . $tutor->id); // Verificamos que se cargue la vista detalle con el ID del Tutor creado previamente
        $this->assertResponseCode(200);

        // Verificacion de resultados
        $this->assertResponseContains($tutor->name); //Verificamos que exista el nombre del Tutor creado en la vista
        $this->assertResponseContains($tutor->dni); //Verificamos que exista la cedula del Tutor creado en la vista
        $this->assertResponseContains($tutor->phone); //Verificamos que exista el telefono del Tutor creado en la vista
        $this->assertResponseContains($tutor->email); //Verificamos que exista el email del Tutor creado en la vista
    }

    /**
     * Prueba de funcionalidad para registrar un nuevo Tutor
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::add()
     */
    public function testAdd(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Cargamos la vista del formulario de creacion
        $this->get('/admin/tutors/add');
        $this->assertResponseCode(200);

        // Creamos un nuevo Tutor de prueba
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/tutors/'); //Cargamos la vista de los Tutores
        $this->assertResponseCode(200);

        // Verificacion de resultados
        $this->assertResponseContains($tutor->name); // Verificamos que en la vista exista el nombre del tutor
        $this->assertResponseContains($tutor->dni); // Verificamos que en la vista exista la cedula del tutor
        $this->assertResponseContains($tutor->phone); // Verificamos que en la vista exista el telefono del tutor
        $this->assertResponseContains($tutor->email); // Verificamos que en la vista exista el email del tutor
    }

    /**
     * Prueba de funcionalidad de editar un Tutor
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion incial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creamos un nuevo Tutor de prueba asociado a un Tenant
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/tutors/'); //Cargamos la vista con el ID del tutor en cuestion
        $this->assertResponseCode(200);

        // Enviamos el formulario con el ID del registro que queremos actualizar y el ID del registro
        $this->post('/admin/tutors/edit/' . $tutor->id, [
            'name' => 'Edit tutor test',
        ]);
        $this->assertResponseCode(302);

        // Verificacion de resultados
        $this->get('/admin/tutors/view/' . $tutor->id); // Verificamos la vista detalle con el ID del tutor que actualizamos
        $this->assertResponseContains('Edit tutor test'); // Verificamos que exista en la vista el valor que hemos enviado en el formulario
        $this->assertResponseNotContains($tutor->name); // Verificamos que se halla cambiado el valor del campo en el formulario enviado
    }

    /**
     * Prueba de funcionalidad de eliminar un Tutor
     *
     * @return void
     * @uses \App\Controller\Admin\TutorsController::delete()
     */
    public function testDelete(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creamos un nuevo tutor asociado a un Tenant
        $tutor = TutorFactory::make([
            'tenant_id' => $this->tenant_id
        ])->persist();

        // Enviamos el formulario a la ruta correspondiente con el ID que deseamos eliminar
        $this->delete('/admin/tutors/delete/' . $tutor->id);

        // Verificacion de resultados
        $res = $this->getRecordExists('Tutors', $tutor->id); //Verificamos la existencia del registro en Base de datos
        $this->assertTrue($res); // Confirmacion de existencia del registro
    }
}
