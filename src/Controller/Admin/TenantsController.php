<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Entity\Lapse;
use App\Model\Entity\Tenant;
use Cake\Event\EventInterface;

/**
 * Tenants Controller
 *
 * @property \App\Model\Table\TenantsTable $Tenants
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantsController extends AppAdminController
{
    /**
     * @var \App\Model\Table\ProgramsTable
     */
    protected $Programs;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->Programs = $this->fetchTable('Programs');
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        parent::beforeRender($event);
        $this->MenuLte->activeItem('tenants');
    }

    /**
     * Index method
     *
     * @return void Renders view
     */
    public function index(): void
    {
        $this->paginate = [];

        $query = $this->Tenants
            ->find('withPrograms')
            ->contain(['CurrentLapse']);

        $tenants = $this->paginate($query);

        $this->set(compact('tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $tenant = $this->Tenants->get($id, contain: [
            'Programs',
            'CurrentLapse' => ['LapseDates'],
        ]);

        $lapses = $this->Tenants->Lapses
            ->find('list', options: [
                'keyField' => 'id',
                'valueField' => 'name',
                'groupField' => 'label_active',
            ])
            ->orderBy(['active' => 'DESC'])
            ->where(['tenant_id' => $id]);

        $lapseSelected = $this->getLapseSelected($tenant, $this->getRequest()->getQuery('lapse_id', null));

        $this->set(compact('tenant', 'lapses', 'lapseSelected'));
    }

    /**
     * @param string $program_id
     * @return void
     */
    public function viewProgram(?string $program_id = null): void
    {
        $program = $this->Programs->get(
            $program_id,
            contain: [
                'Tenants',
                'InterestAreas',
            ],
        );

        $this->set(compact('program'));
    }

    /**
     * @param \App\Model\Entity\Tenant $tenant
     * @param string|int|null $lapse_id
     * @return \App\Model\Entity\Lapse|null
     */
    protected function getLapseSelected(Tenant $tenant, int|string|null $lapse_id): ?Lapse
    {
        if (empty($lapse_id) && !empty($tenant->current_lapse)) {
            return $tenant->current_lapse;
        }

        if (!empty($lapse_id)) {
            return $this->Tenants->Lapses->get($lapse_id, contain: ['LapseDates']);
        }

        return $this->Tenants->Lapses->find()
            ->where(['tenant_id' => $tenant->id])
            ->contain(['LapseDates'])
            ->orderBy(['id' => 'DESC'])
            ->first();
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $tenant = $this->Tenants->newEmptyEntity();
        if ($this->request->is('post')) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());

            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $programs = $this->Tenants->Programs->find('list', options: [
            'groupField' => 'area_label',
            'limit' => 200,
        ]);

        $this->set(compact('tenant', 'programs'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function addProgram()
    {
        $program = $this->Programs->newEmptyEntity();
        if ($this->request->is('post')) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());

            if ($this->Programs->save($program)) {
                $this->Flash->success(__('The program has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The program could not be saved. Please, try again.'));
        }

        $this->set(compact('program'));
    }

    /**
     * @param string|int $program_id
     * @return \Cake\Http\Response|null
     */
    public function addInterestArea(int|string|null $program_id = null)
    {
        $interestArea = $this->Programs->InterestAreas->newEmptyEntity();
        $program = $this->Programs->get($program_id);
        if ($this->request->is('post')) {
            $interestArea = $this->Programs->InterestAreas->patchEntity($interestArea, $this->request->getData());
            $interestArea->program_id = $program_id;
            if ($this->Programs->InterestAreas->save($interestArea)) {
                $this->Flash->success(__('The interest area has been saved.'));

                return $this->redirect(['action' => 'viewProgram', $program_id]);
            }
            $this->Flash->error(__('The interest area could not be saved. Please, try again.'));
        }

        $this->set(compact('interestArea', 'program'));
    }

    /**
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $tenant = $this->Tenants->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }

        $this->set(compact('tenant'));
    }

    /**
     * @param string|int $program_id
     * @return \Cake\Http\Response|null
     */
    public function editProgram(int|string|null $program_id = null)
    {
        $program = $this->Programs->get($program_id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $program = $this->Programs->patchEntity($program, $this->request->getData());
            if ($this->Programs->save($program)) {
                $this->Flash->success(__('The program has been saved.'));

                return $this->redirect(['action' => 'viewProgram', $program_id]);
            }
            $this->Flash->error(__('The program could not be saved. Please, try again.'));
        }
        $this->set(compact('program'));
    }

    /**
     * @param string|int $interestArea_id
     * @return \Cake\Http\Response|null
     */
    public function editInterestArea(int|string|null $interestArea_id = null)
    {
        $interestArea = $this->Programs->InterestAreas->get($interestArea_id);
        $program = $this->Programs->get($interestArea->program_id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $interestArea = $this->Programs->InterestAreas->patchEntity($interestArea, $this->request->getData());
            if ($this->Programs->InterestAreas->save($interestArea)) {
                $this->Flash->success(__('The interest area has been saved.'));

                return $this->redirect(['action' => 'viewProgram', $program->id]);
            }
            $this->Flash->error(__('The interest area could not be saved. Please, try again.'));
        }
        $this->set(compact('interestArea', 'program'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenant = $this->Tenants->get($id);
        if ($this->Tenants->delete($tenant)) {
            $this->Flash->success(__('The tenant has been deleted.'));
        } else {
            $this->Flash->error(__('The tenant could not be deleted. Please, try again.'));
        }

         return $this->redirect(['action' => 'index']);
    }
}
