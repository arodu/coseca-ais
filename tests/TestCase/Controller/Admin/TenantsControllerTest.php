<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\InterestAreaFactory;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\TenantFactory;
use Cake\TestSuite\IntegrationTestTrait;
use CakephpTestSuiteLight\Fixture\TruncateDirtyTables;

/**
 * Pruebas para el controlador TenantsController
 *
 * @uses \App\Controller\Admin\TenantsController
 */
class TenantsControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;
    use TruncateDirtyTables;

    /**
     * Prueba de funcionalidad para cargar la vista de todas los Programas/Sedes
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::index()
     */
    public function testIndex(): void
    {
        // Configuracion inicial
        // Verificacion de acceso
        $this->get('/admin/tenants');
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/tenants'); // Carga la vista de los Programas/Sedes
        $this->assertResponseCode(200);

        //Creacion de un Tenant asociado a un Programa
        $tenant = $this->getCompleteTenant()->persist();
        $this->get('/admin/tenants'); //Carga la vista de todos los registros
        $this->assertResponseCode(200);
        $this->assertResponseContains($tenant->location->name); //Verificamos que exista el nombre del Tenant en la vista
        $this->assertResponseContains($tenant->program->name); //Verificamos que exista la abreviacion del Tenant en la vista
    }

    /**
     * Prueba de funcionalidad para ver detalle de un Programa/Sede
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::view()
     */
    public function testView(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Ejecucion de acciones
        $program = ProgramFactory::make()->persist(); //Creacion de un Programa
        // Creacion de un Lapso
        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        //Creacion de un Tenant asociado a un Programa
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
            'name' => 'San Juan',
            'abbr' => 'SJM',
            'active' => true,
        ])->persist();

        // Verificacion de acciones
        $this->get('/admin/tenants/view/' . $tenant->id); // Verificar que se cargue la vista detalle del Tenant
        $this->assertResponseCode(200);

        $this->assertEquals(true, $lapse->active); // Verificamos que el registro este activo
        $this->assertResponseContains($program->name); // Verificamos que existe en la vista el nombre del programa
        $this->assertResponseContains($program->abbr); // Verificamos que existe en la vista la abreviacion del programa
    }

    /**
     * Prueba de funcionalidad para ver detalle de un Programa
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::viewProgram()
     */
    public function testViewProgram(): void
    {
        // Configuracion incial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Verificacion de acciones
        $this->get('/admin/tenants/view-program/' . $this->tenant->program->id); //Verificamos que cargue la vista con el ID del programa correspondiente
        $this->assertResponseCode(200);

        // Verificacion de resultados
        $this->assertResponseContains($this->tenant->location->name); // Verificamos que la vista contenga el nombre del Tenant
        $this->assertResponseContains($this->tenant->location->abbr); // Verificamos que la vista contenga la abreviacion del Tenant

        $this->assertResponseContains($this->tenant->program->name); // Verificamos que la vista contenga el nombre del Programa

        $this->assertResponseContains($this->tenant->program->interest_areas[0]->name); // Verificamos que la vista contenga el nombre del Area de interes
    }

    /**
     * Prueba de funcionalidad para agregar una nueva Sede
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::add()
     */
    public function testAdd(): void
    {
        // COnfiguracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = $this->tenant->program; // Obtenemos el Programa asociado al Tenant

        // Verificamos que cargue la vista para agregar un nuevo registro
        $this->get('/admin/tenants/add/' . $program->id);
        $this->assertResponseCode(200);

        // Verificacion de acciones
        $program = ProgramFactory::make()->persist(); //Creamos un Programa nuevo

        // Creamos una nueva Sede asociada al Programa creado previamente
        $this->post('/admin/tenants/add/' . $program->id, [
            'name' => 'Nueva sede test',
            'active' => true,
        ]);

        // Verificacion de resultados
        $this->assertResponseContains('Nueva sede test'); // Verificamos que exista el nombre del registro que hemos creado
    }

    /**
     * Prueba de funcionalidad para agregar un nuevo Programa
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::addProgram()
     //  */
    public function testAddProgram(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $this->get('/admin/tenants/add-program'); // Verificacion de carga de vista para crear nuevo Programa
        $this->assertResponseCode(200);

        // Verificaion de acciones
        $this->post('/admin/tenants/add-program', [
            'name' => 'Nuevo programa test',
            'abbr' => 'INF',
        ]); // Creamos un nuevo Programa con datos de prueba

        // Verificacion de resultados
        $this->assertResponseContains('Nuevo programa test'); //Verificamos que exista el nombre del Programa que hemos creado
    }

    /**
     * Prueba de funcionalidad para agregar un Area de interes a un Programa
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::addInterestArea()
     */
    public function testAddInterestArea(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creamos un programa previamente
        $program = ProgramFactory::make()->persist();

        // Verificacion de acciones
        $this->get('/admin/tenants/add-interest-area/' . $program->id); // Verificamos que cargue la vista detalle del Programa creado
        $this->assertResponseCode(200);

        // Enviamos el formulario de prueba para crear un Area de interes asociado al Programa
        $this->post('/admin/tenants/add-interest-area/' . $program->id, [
            'name' => 'Area de interes',
            'Description' => 'Campo descripcion',
            'program_id' => $program->id,
        ]);

        // Verificacion de resultado
        $this->get('/admin/tenants/view-program/' . $program->id); // Veirficamos que cargue la vista detalle del programa que hemos creado
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para editar un Tenant
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = ProgramFactory::make()->persist(); //Creamos un Programa nuevo
        // Creamos un Lapso nuevo asociado a un Tenant
        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->persist();

        //Verificacion de acciones
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist(); // Creamos un Tenant nuevo

        // Envio de informacion para actualizar el Tenant
        $this->post('/admin/tenants/view/' . $tenant->id, [
            'name' => 'Tenant editado',
        ]);

        // Verificacion de resultados
        $this->get('/admin/tenants/view/' . $tenant->id); // Verificamos que cargue la vista del Tenant correspondiente
        $this->assertResponseCode(200);

        $this->assertEquals(true, $lapse->active); //Verificamos que el Tenant tenga un lapso activo
        $this->assertResponseContains($program->name); // Verificamos que el Programa tenga nombre
        $this->assertResponseContains($program->abbr); // Verificamos que el Programa tenga abreviacion
    }

    /**
     * Prueba de funcionalidad para editar un Programa
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::editProgram()
     */
    public function testEditProgram(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Verificacion de acciones
        $program = ProgramFactory::make()->persist(); // Creacion de un Programa

        // Verificacion de carga de la vista detalle del Programa creado
        $this->get('/admin/tenants/edit-program/' . $program->id);
        $this->assertResponseCode(200);

        // Enviamos el formulario con el ID del Programa a editar y la informacio
        $this->post('/admin/tenants/edit-program/' . $program->id, [
            'name' => 'Programa editado',
        ]);
        $this->assertResponseCode(302);

        // Verificacion de resultados
        $this->get('/admin/tenants/view-program/' . $program->id); //Verificamos que cargue la vista detalle del Programa
        $this->assertResponseContains('Programa editado'); // Verificamos que exista en la vista la informacion que enviamos
        $this->assertResponseNotContains($program->name); // Verificamos que la informacion anterior no exista
    }

    /**
     * Prueba de funcionalidad para editar un Area de interes.
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::editInterestArea()
     */
    public function testEditInterestArea(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = ProgramFactory::make()->persist(); //Creamos un Programa
        // Creamos un Area de interes
        $area_interes = InterestAreaFactory::make([
            'program_id' => $program->id,
        ])->persist();

        // Verificacion de aaciones
        $this->get('/admin/tenants/edit-interest-area/' . $area_interes->id); //Verificamos que cargue la vista del Area de interes que hemos creado
        $this->assertResponseCode(200);

        // Actualizamos el area de interes.
        $this->post('/admin/tenants/edit-interest-area/' . $area_interes->id, [
            'name' => 'Name area interest editing',
        ]);
        $this->assertResponseCode(302);

        // Verificacion de resultados
        $this->get('/admin/tenants/view-program/' . $program->id); //Verificamos que cargue la vista del Programa correspondiente
        $this->assertResponseContains('Name area interest editing'); //Verificamos que exista la informacion que hemos enviado
    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\Admin\TenantsController::delete()
     */
    // public function testDelete(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }
}
