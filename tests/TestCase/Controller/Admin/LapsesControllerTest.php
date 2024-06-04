<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Enum\StatusDate;
use App\Model\Field\StageField;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\TenantFactory;
use Cake\TestSuite\IntegrationTestTrait;

/**
 * App\Controller\Admin\LapsesController Test Case
 *
 * Pruebas para el controlador `LapsesController`
 *
 * @uses \App\Controller\Admin\LapsesController
 */
class LapsesControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Prueba de funcionalidad para agregar a traves de un formulario un Lapso
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::add()
     */
    public function testAdd(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Verificacion de acciones
        $this->get('/admin/lapses/add/' . $this->tenant->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);
        $this->assertResponseContains($this->tenant->location->name); // Verificacion que exista el nombre del Tenant en la vista

        $this->post('/admin/lapses/add/' . $this->tenant->id, [
            'name' => 'Test',
        ]); // Envio del formulario con la actualizacion de la informacion

        $this->assertResponseContains('Test'); //Verificar que se ha actualizado la informacion correctamente
        $this->get('/admin/tenants/view/' . $this->tenant->id); //Verificar que nuevamente cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para editar el registro de un Lapso
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::edit()
     */
    public function testEdit(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.
        // Creacion de un Tenant
        $tenant = $this->createCompleteTenant()->persist();

        $this->get('/admin/tenants/view/' . $tenant->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);

        // Creacion de un Lapso
        $lapse = LapseFactory::make([
            'tenant_id' => $tenant->id,
        ])->persist();

        $this->get('/admin/lapses/edit/' . $lapse->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);

        // Envio del formulario con la actualizacion de la informacion
        $this->post('/admin/lapses/edit/' . $lapse->id, [
            'name' => 'Lapso editado',
        ]);

        // Verificacion de resultados
        $this->get('/admin/tenants/view/' . $tenant->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);
        $this->assertResponseContains('Lapso editado');
        $this->assertResponseNotContains($lapse->name);
    }

    /**
     * Prueba de funcionalidad para editar la fecha de un Lapso
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::editDates()
     * @skiped
     */
    public function testEditDates(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        $program = $this->createProgram()->persist(); //Creacion de un programa

        // Creacion de un Tenant
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist();

        // Creacion de un Lapso
        $lapse = LapseFactory::make([
            'tenant_id' => $tenant->id,
        ])->getEntity()->toArray();

        // Verificacion de resultados
        $lapse = $this->addRecord('Lapses', $lapse); //Buscamos el lapso en la table
        $lapse = $this->loadInto($lapse, ['LapseDates']); //Cargar los LapsesDates de un Lapso

        /** @var \App\Model\Entity\Lapse  $lapse */
        $lapses_date = $lapse->getDates(StageField::REGISTER); //Obtenemos el LapseDate de prueba

        $this->get('/admin/lapses/edit-dates/' . $lapses_date->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);
    }

    /**
     * Prueba de funcionalidad para cambiar el Status
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::changeActive()
     */
    public function testChangeActive(): void
    {
        // Configuracion inicial
        $this->setAuthSession(); // Establece una sesión de autenticación para simular un usuario autenticado.

        // Creacion de un Lapso
        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id,
        ])->getEntity()->toArray();

        $lapse = $this->addRecord('Lapses', $lapse); //Buscamos el lapso en la table
        $lapse = $this->loadInto($lapse, ['LapseDates']); //Cargar los LapsesDates de un Lapso

        /** @var \App\Model\Entity\Lapse  $lapse */
        $lapses_date = $lapse->getDates(StageField::REGISTER); //Obtenemos el LapseDate de prueba

        $this->get('/admin/lapses/edit-dates/' . $lapses_date->id); // Verificar que cargue la vista con el ID correspondiente
        $this->assertResponseCode(200);

        // Escenario fecha unica pasada
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => true,
            'start_date' => $this->today->subDays(15),
        ]); //Enviamos el formulario caducado y con fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `Caducado` y tiene `Fecha unica` verificamos que exista `Caducado` en la vista
        if ($this->assertEquals(StatusDate::TIMED_OUT, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Caducado');
        }

        // Escenario fecha unica actual
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => true,
            'start_date' => $this->today,
        ]); //Enviamos el formulario con fecha actual y con fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `En Progreso` y tiene `Fecha unica` verificamos que exista `En Porgreso` en la vista
        if ($this->assertEquals(StatusDate::IN_PROGRESS, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'En Porgreso');
        }

        // Escenario fecha unica Pendiente
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => true,
            'start_date' => $this->today->addDays(15),
        ]); //Enviamos el formulario pendiente y con fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `Pendiente` y tiene `Fecha unica` verificamos que exista `Pendiente` en la vista
        if ($this->assertEquals(StatusDate::PENDING, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Pendiente');
        }

        // Escenario Caducado de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => false,
            'start_date' => $this->today->subDays(20),
            'end_date' => $this->today->subDays(5),
        ]); //Enviamos el formulario con ambas fechas Caducadas y sin fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `Caducado` y no tiene `Fecha unica` verificamos que exista `Caducado` en la vista
        if ($this->assertEquals(StatusDate::TIMED_OUT, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Caducado');
            $this->assertResponseCode(200);
        }

        // Escenario En Progreso de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => false,
            'start_date' => $this->today->subDays(5),
            'end_date' => $this->today->addDays(25),
        ]); //Enviamos el formulario con fechas En progreso y sin fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `En Progreso` y no tiene `Fecha unica` verificamos que exista `En Porgreso` en la vista
        if ($this->assertEquals(StatusDate::IN_PROGRESS, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'En Porgreso');
            $this->assertResponseCode(200);
        }

        // Escenario Pendiente de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => false,
            'start_date' => $this->today->addDays(5),
            'end_date' => $this->today->addDays(20),
        ]); //Enviamos el formulario con fechas Pendientes y sin fecha unica

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date); //Obtenemos el status del LapseDate

        // Si el Status es `Pendiente` y no tiene `Fecha unica` verificamos que exista `Pendiente` en la vista
        if ($this->assertEquals(StatusDate::PENDING, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Pendiente');
            $this->assertResponseCode(200);
        }
    }
}
