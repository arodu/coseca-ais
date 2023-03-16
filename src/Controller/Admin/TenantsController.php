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
    public function initialize(): void
    {
        parent::initialize();

        $this->Programs = $this->fetchTable('Programs');
    }


    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('tenants');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['CurrentLapse'],
        ];

        $query = $this->Tenants
            ->find('withPrograms');

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
        $tenant = $this->Tenants->get($id, [
            'contain' => [
                'Programs',
                'CurrentLapse' => ['LapseDates'],
            ],
        ]);

        $lapses = $this->Tenants->Lapses
            ->find('list', [
                'keyField' => 'id',
                'valueField' => 'name',
                'groupField' => 'label_active',
            ])
            ->order(['active' => 'DESC'])
            ->where(['tenant_id' => $id]);

        $lapseSelected = $this->getLapseSelected($tenant, $this->getRequest()->getQuery('lapse_id', null));

        // @todo Something
        //$lapse_id = $this->getRequest()->getQuery('lapse_id');
        //if (empty($lapse_id) || $lapse_id == $tenant->current_lapse->id) {
        //    $lapseSelected = $tenant->current_lapse;
        //} else {
        //    $lapseSelected = $this->Tenants->Lapses->find()
        //        ->where(['id' => $lapse_id])
        //        ->contain(['LapseDates'])
        //        ->first();
        //}

        $this->set(compact('tenant', 'lapses', 'lapseSelected'));
    }

    public function viewProgram($program_id = null)
    {
        $program = $this->Programs->get($program_id, [
            'contain' => ['Tenants']
        ]);

        $this->set(compact('program'));
    }

    private function getLapseSelected(Tenant $tenant, $lapse_id): ?Lapse
    {
        if (empty($lapse_id) && !empty($tenant->current_lapse)) {
            return $tenant->current_lapse;
        }

        if (!empty($lapse_id)) {
            return $this->Tenants->Lapses->get($lapse_id, [
                'contain' => ['LapseDates']
            ]);
        }

        return $this->Tenants->Lapses->find()
            ->where(['tenant_id' => $tenant->id])
            ->contain(['LapseDates'])
            ->order(['id' => 'DESC'])
            ->first();
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
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
        $programs = $this->Tenants->Programs->find('list', [
            'groupField' => 'area_label',
            'limit' => 200,
        ]);

        $this->set(compact('tenant', 'programs'));
    }

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
     * Edit method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => [],
        ]);
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

    public function editProgram($program_id = null)
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
     * Delete method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
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
