<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\InstitutionFactory;
use App\Test\Factory\TenantFactory;
use App\Test\Factory\TutorFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\StudentsController Test Case
 *
 * Pruebas para el controlador StudentsCrontroller
 *
 * @uses \App\Controller\Admin\StudentsController
 */
class StudentsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Prueba de funcionalidad para obtener la vista y que exista en ella los datos de Estudiantes.
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::index()
     */
    public function testIndex(): void
    {
        // Configuracion inicial
        $this->get('/admin/students');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/students'); //Verificar que cargue la ruta con la vista correspondiente
        $this->assertResponseCode(200);

        // Crear un Usario con rol Admin para la prueba
        $user = $this->createUserWithUserRole();
        $this->assertResponseCode(200);
        // Verificacion de resultados
        $this->assertResponseContains((string)$user->students[0]->dni); //Verificacion que exista el DNI del estudiante en la vista
        $this->assertResponseContains((string)$user->students[0]->email); //Verificacion que exista el email del estudiante en la vista
    }

    /**
     * Prueba de funcionalidad para obtener la vista detalle de un usuario
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::view()
     */
    public function testView(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa
        $student = $this->getUserStudentCreated($program); //Creacion de un estudiante asociado a un programa

        // Verificacion de resultados
        $this->get('/admin/students/view/' . $student->id); //Cargar la vista con el ID del estudiante creado
        $this->assertResponseContains((string)$student->dni); //Verificacion que exista el DNI del estudiante en la vista
        $this->assertResponseContains((string)$student->email); //Verificacion que exista el email del estudiante en la vista
        $this->assertResponseContains((string)$program->name); //Verificacion que exista el nombre del programa en la vista
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para cargar la vista Info del Estudiante
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::info()
     */
    public function testInfo(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa
        $student = $this->getUserStudentCreated($program); //Creacion de un estudiante asociado a un programa

        $this->get('/admin/students/info/' . $student->id); //Cargar la vista con el ID del estudiante creado
        $this->assertResponseContains((string)$student->dni); //Verificacion que exista el DNI del estudiante en la vista
        $this->assertResponseContains((string)$student->email); //Verificacion que exista el email del estudiante en la vista
        $this->assertResponseContains((string)$program->name); //Verificacion que exista el nombre del programa en la vista
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para Adscripciones de Estudiante
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::adscriptions()
     */
    public function testAdscriptions(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa
        $student = $this->getUserStudentCreated($program); //Creacion de un estudiante asociado a un programa

        $institution = InstitutionFactory::make(['tenant_id' => $this->tenant_id])->persist(); // Creacion de una Institucion
        $tutor = TutorFactory::make(['tenant_id' => $this->tenant_id])->persist(); // Creacion de un Tutor

        $this->get('/admin/stage/adscriptions/add/' . $student->id); //Carga la vista Adscripciones con el ID del Estudiante correspondiente
        $this->assertResponseCode(200);

        //Verificaion de acciones
        $this->post('/admin/stage/adscriptions/add/' . $student->id, [
            'institution_project_id' => $institution->id,
            'tutor_id' => $tutor->id,
            'principal' => false,
        ]); // Envio de formulario actualizando los datos, sin dejar esta adscricion como principal.
        $this->assertResponseCode(200);

        $this->post('/admin/stage/adscriptions/add/' . $student->id, [
            'institution_project_id' => $institution->id,
            'tutor_id' => $tutor->id,
            'principal' => true,
        ]);// Envio de formulario actualizando los datos, dejando esta adscricion como principal.
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para verificar la vista de Configuraciones de un Estudiante.
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::settings()
     */
    public function testSettings(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa
        $student = $this->getUserStudentCreated($program); //Creacion de un estudiante asociado a un programa

        // Verificacion de resultados.
        $this->get('/admin/students/settings/' . $student->id); //Cargar la vista con el ID del estudiante creado
        $this->assertResponseContains((string)$student->tenant->name); //Verificacion que exista el nombre del estudiante en la vista
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para verificar el Seguimiento de un Estudiante.
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::tracking()
     */
    public function testTracking(): void
    {
        $this->setAuthSession();
        $student = $this->createCompleteStudent()->persist();

        // Verificacion de resultados.
        $this->get('/admin/students/tracking/' . $student->id); //Verificacion de la vista con el ID correspondiente
        $this->assertResponseCode(200);
        $this->assertResponseContains('<h3 class="card-title">Seguimiento: ' . $this->tenant->lapses[0]->name . '</h3>'); //Verificacion del nombre del lapso en la vista
    }

    /**
     * Test prints method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::prints()
     */
    // public function testPrints(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::add()
     */
    // public function testAdd(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa.
        $student = $this->getUserStudentCreated($program); //Creacion de un estudiante asociado a un programa.

        // Comprobar que cargue la vista con el ID del estudiante seleccionado
        $this->get('/admin/stage/register/edit/' . $student->id);
        $this->assertResponseCode(200);

        $this->post('/admin/stage/register/edit/' . $student->id, [
            'name' => 'prueba edit',
        ]); //Envio de formulario actualizando campos

        // Verificacion de resultados
        $this->get('/admin/student/view/' . $student->id); //Verificacion que cargue la vista detalle del Estudiante
        $this->assertResponseCode(200);
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::delete()
     */
    // public function testDelete(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test changeEmail method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::changeEmail()
     */
    // public function testChangeEmail(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    /**
     * Test newProgram method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::newProgram()
     */
    public function testNewProgram(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa.
        $tenant = TenantFactory::make(['program_id' => $program->id])->persist(); //Creacion de un Tenant

        $program = $this->createProgram()->persist(); //Creacion de otro programa
        $student = $this->getUserStudentCreated($program); // Creacion de Estudiante asociado a un programa

        $this->post('/admin/students/view/' . $student->id, [
            'tenant_id' => $tenant->id,
            'active' => false,
        ]); //Envio de formulario desactivando al Estudiante
        $this->assertResponseCode(200);

        $this->post('/admin/students/view/' . $student->id, [
            'tenant_id' => $tenant->id,
            'active' => true,
        ]); //Envio de formulario activando al Estudiante
        $this->assertResponseCode(200);
    }

    /**
     * Test deactivate method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::deactivate()
     */
    public function testDeactivate(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa.
        $tenant = TenantFactory::make(['program_id' => $program->id])->persist(); //Creacion de un Tenant

        $program = $this->createProgram()->persist(); //Creacion de otro programa
        $student = $this->getUserStudentCreated($program); // Creacion de Estudiante asociado a un programa

        $this->post('/admin/students/view/' . $student->id, [
            'tenant_id' => $tenant->id,
            'active' => false,
        ]); //Envio de formulario para Desactivar Estudiante
        $this->assertResponseCode(200);
    }

    /**
     * Test reactivate method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::reactivate()
     */
    public function testReactivate(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $program = $this->createProgram()->persist(); //Creacion de un programa.
        $student = $this->getUserStudentCreated($program); // Creacion de Estudiante asociado a un programa

        $this->post('/admin/students/view/' . $student->id, [
            'active' => true,
        ]);//Envio de formulario para Desactivar Estudiante
        $this->assertResponseCode(200);
    }

    /**
     * Test bulkActions method
     *
     * @return void
     * @uses \App\Controller\Admin\StudentsController::bulkActions()
     */
    // public function testBulkActions(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
