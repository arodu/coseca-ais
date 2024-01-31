<?php

declare(strict_types=1);

namespace App\Test\TestCase\Controller\Admin;

use App\Controller\Admin\LapsesController;
use App\Enum\StatusDate;
use App\Model\Entity\LapseDate;
use App\Model\Field\StageField;
use App\Test\Factory\LapseFactory;
use App\Test\Factory\ProgramFactory;
use App\Test\Factory\TenantFactory;
use App\View\Helper\AppHelper;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use App\Test\Factory\CreateDataTrait;
use Cake\I18n\FrozenDate;

/**
 * App\Controller\Admin\LapsesController Test Case
 *
 * @uses \App\Controller\Admin\LapsesController
 */
class LapsesControllerTest extends AdminTestCase
{
    use IntegrationTestTrait;

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::add()
     */
    public function testAdd(): void
    {
        $this->setAuthSession();

        $program = $this->program;
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist();

        $this->get('/admin/lapses/add/' . $tenant->id);
        $this->assertResponseCode(200);
        $this->assertResponseContains($tenant->name);

        $this->post('/admin/lapses/add/' . $program->id, [
            'name' => 'Test',
        ]);

        $this->assertResponseContains('Test');

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::edit()
     * @skiped
     */
    public function testEdit(): void
    {
        $this->setAuthSession();

        $program = $this->program;
        $tenant = TenantFactory::make([
            'program_id' => $program->id,
        ])->persist();

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);

        $lapse = LapseFactory::make([
            'tenant_id' => $tenant->id
        ])->persist();

        $this->get('/admin/lapses/edit/' . $lapse->id);
        $this->assertResponseCode(200);

        $this->post('/admin/lapses/edit/' . $lapse->id, [
            'name' => 'Lapso editado',
        ]);
        $this->assertResponseCode(302);

        $this->get('/admin/tenants/view/' . $tenant->id);
        $this->assertResponseCode(200);
        $this->assertResponseContains('Lapso editado');
        $this->assertResponseNotContains($lapse->name);
    }

    /**
     * Test editDates method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::editDates()
     * @skiped
     */
    public function testEditDates(): void
    {
        $this->setAuthSession();

        $program = $this->program;
        $tenant = TenantFactory::make([
            'program_id' => $program->id
        ])->persist();

        $lapse = LapseFactory::make([
            'tenant_id' => $tenant->id
        ])->getEntity()->toArray();

        $lapse = $this->addRecord('Lapses', $lapse);
        $lapse = $this->loadInto($lapse, ['LapseDates']);

        /** @var \App\Model\Entity\Lapse  $lapse */
        $lapses_date = $lapse->getDates(StageField::REGISTER);

        $this->get('/admin/lapses/edit-dates/' . $lapses_date->id);
        $this->assertResponseCode(200);
    }

    /**
     * Test changeActive method
     *
     * @return void
     * @uses \App\Controller\Admin\LapsesController::changeActive()
     */
    public function testChangeActive(): void
    {
        // Configuracion inicial
        $this->setAuthSession();


        $lapse = LapseFactory::make([
            'tenant_id' => $this->tenant_id
        ])->getEntity()->toArray();

        $lapse = $this->addRecord('Lapses', $lapse);
        $lapse = $this->loadInto($lapse, ['LapseDates']);

        /** @var \App\Model\Entity\Lapse  $lapse */
        $lapses_date = $lapse->getDates(StageField::REGISTER);

        $this->get('/admin/lapses/edit-dates/' . $lapses_date->id);
        $this->assertResponseCode(200);

        // Escenario fecha unica pasada
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => True,
            'start_date' => $this->today->subDays(15),
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::TIMED_OUT, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Caducado');
        }

        // Escenario fecha unica actual
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => True,
            'start_date' => $this->today
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::IN_PROGRESS, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'En Porgreso');
        }

        // Escenario fecha unica Pendiente
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => True,
            'start_date' => $this->today->addDays(15)
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::PENDING, $lapseDateStatus) && $lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Pendiente');
        }

        // Escenario Caducado de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => False,
            'start_date' => $this->today->subDays(20),
            'end_date' => $this->today->subDays(5)
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::TIMED_OUT, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Caducado');
            $this->assertResponseCode(200);
        }

        // Escenario En Progreso de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => False,
            'start_date' => $this->today->subDays(5),
            'end_date' => $this->today->addDays(25)
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::IN_PROGRESS, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'En Porgreso');
            $this->assertResponseCode(200);
        }

        // Escenario Pendiente de fecha inicio con fecha fin sin fecha unica
        $this->post('/admin/lapses/edit-dates/' . $lapses_date->id, [
            'is_single_date' => False,
            'start_date' => $this->today->addDays(5),
            'end_date' => $this->today->addDays(20)
        ]);

        $lapseDateStatus = $this->getLapsesDatesStatus($lapses_date);

        if ($this->assertEquals(StatusDate::PENDING, $lapseDateStatus) && !$lapses_date->is_single_date) {
            $this->getResponseContainsForUrl('/admin/tenants/view/', $this->tenant_id, 'Pendiente');
            $this->assertResponseCode(200);
        }

    }
}
