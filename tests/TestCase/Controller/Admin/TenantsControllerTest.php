<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Test\Factory\InterestAreaFactory;
use App\Test\Factory\ProgramFactory;
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
        $tenant = $this->createCompleteTenant()->persist();
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
        $this->get('/admin/tenants/view/' . $this->tenant->id);
        $this->assertResponseCode(302);

        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        $this->get('/admin/tenants/view/' . $this->tenant->id); // Verificar que se cargue la vista detalle del Tenant
        $this->assertResponseCode(200);

        $this->assertResponseContains($this->tenant->program->name);
        $this->assertResponseContains($this->tenant->program->abbr);
        $this->assertResponseContains($this->tenant->location->name);
        $this->assertResponseContains($this->tenant->lapses[0]->name);
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
}
