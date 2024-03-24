<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Entity\Lapse;
use App\Model\Entity\Tenant;
use App\Utility\FilterTenantUtility;
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
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->MenuLte->activeItem('tenants');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [];

        $query = $this->Tenants
            ->find('complete')
            ->contain(['CurrentLapse']);

        $tenants = $this->paginate($query);

        $this->set(compact('tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tenant = $this->Tenants
            ->find('complete')
            ->where(['Tenants.id' => $id])
            ->contain(['CurrentLapse' => ['LapseDates']])
            ->firstOrFail();

        $lapses = $this->Tenants->Lapses
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
                'groupField' => 'label_active',
            ])
            ->order(['active' => 'DESC'])
            ->where(['tenant_id' => $id]);

        $lapseSelected = $this->getLapseSelected($tenant, $this->getRequest()->getQuery('lapse_id', null));

        $this->set(compact('tenant', 'lapses', 'lapseSelected'));
    }

    /**
     * @param string $program_id
     * @return \Cake\Http\Response|null|void
     */
    public function viewProgram($program_id = null)
    {
        $program = $this->Tenants->Programs->get($program_id, [
            'contain' => [
                'Tenants' => [
                    'Locations',
                ],
                'Areas',
                'InterestAreas',
            ],
        ]);

        $this->set(compact('program'));
    }

    /**
     * @param \App\Model\Entity\Tenant $tenant
     * @param int|string $lapse_id
     * @return \App\Model\Entity\Lapse|null
     */
    private function getLapseSelected(Tenant $tenant, $lapse_id): ?Lapse
    {
        if (empty($lapse_id) && !empty($tenant->current_lapse)) {
            return $tenant->current_lapse;
        }

        if (!empty($lapse_id)) {
            return $this->Tenants->Lapses->get($lapse_id, [
                'contain' => ['LapseDates'],
            ]);
        }

        return $this->Tenants->Lapses->find()
            ->where(['tenant_id' => $tenant->id])
            ->contain(['LapseDates'])
            ->order(['id' => 'DESC'])
            ->first();
    }

    /**
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tenant = $this->Tenants->newEmptyEntity();
        $program_id = $this->getRequest()->getQuery('program_id', null);

        if ($this->getRequest()->is('post')) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));
                $user = $this->Authentication->getIdentity()->getOriginalData();
                FilterTenantUtility::add($user, $tenant->id);

                return $this->redirect(['action' => 'view', $tenant->id]);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }

        $locations = $this->Tenants->Locations->find('list');
        $programs = $this->Tenants->Programs->find('listGrouped');

        $this->set(compact('tenant', 'programs', 'locations', 'program_id'));
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function addProgram()
    {
        $program = $this->Tenants->Programs->newEmptyEntity();
        if ($this->request->is('post')) {
            $program = $this->Tenants->Programs->patchEntity($program, $this->request->getData());

            if ($this->Tenants->Programs->save($program)) {
                $this->Flash->success(__('The program has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The program could not be saved. Please, try again.'));
        }

        $this->set(compact('program'));
    }

    /**
     * @param int|string $program_id
     * @return \Cake\Http\Response|null|void
     */
    public function addInterestArea($program_id = null)
    {
        $interestArea = $this->Tenants->Programs->InterestAreas->newEmptyEntity();
        $program = $this->Tenants->Programs->get($program_id, [
            'contain' => ['Areas'],
        ]);
        if ($this->request->is('post')) {
            $interestArea = $this->Tenants->Programs->InterestAreas->patchEntity($interestArea, $this->request->getData());
            $interestArea->program_id = $program_id;
            if ($this->Tenants->Programs->InterestAreas->save($interestArea)) {
                $this->Flash->success(__('The interest area has been saved.'));

                return $this->redirect(['action' => 'viewProgram', $program_id]);
            }
            $this->Flash->error(__('The interest area could not be saved. Please, try again.'));
        }

        $this->set(compact('interestArea', 'program'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => ['Programs'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tenant = $this->Tenants->patchEntity($tenant, $this->request->getData());
            if ($this->Tenants->save($tenant)) {
                $this->Flash->success(__('The tenant has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }

        $locations = $this->Tenants->Locations->find('list');

        $this->set(compact('tenant', 'locations'));
    }

    /**
     * @param int|string $program_id
     * @return \Cake\Http\Response|null|void
     */
    public function editProgram($program_id = null)
    {
        $program = $this->Tenants->Programs->get($program_id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $program = $this->Tenants->Programs->patchEntity($program, $this->request->getData());
            if ($this->Tenants->Programs->save($program)) {
                $this->Flash->success(__('The program has been saved.'));

                return $this->redirect(['action' => 'viewProgram', $program_id]);
            }
            $this->Flash->error(__('The program could not be saved. Please, try again.'));
        }
        $this->set(compact('program'));
    }

    /**
     * @param int|string $interestArea_id
     * @return \Cake\Http\Response|null|void
     */
    public function editInterestArea($interestArea_id = null)
    {
        $interestArea = $this->Tenants->Programs->InterestAreas->get($interestArea_id);
        $program = $this->Tenants->Programs->get($interestArea->program_id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $interestArea = $this->Tenants->Programs->InterestAreas->patchEntity($interestArea, $this->request->getData());
            if ($this->Tenants->Programs->InterestAreas->save($interestArea)) {
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
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // No se deberia eliminar un Tenant
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $tenant = $this->Tenants->get($id);
    //     if ($this->Tenants->delete($tenant)) {
    //         $this->Flash->success(__('The tenant has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The tenant could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
