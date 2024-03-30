<?php

declare(strict_types=1);

namespace Manager\Controller;

use App\Model\Field\UserRole;
use App\Model\Table\TenantsTable;
use Manager\Controller\AppController;

/**
 * Tenants Controller
 *
 * @method \Manager\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TenantsController extends AppController
{
    protected TenantsTable $Locations;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Tenants = $this->fetchTable('Tenants');
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
        $locations = $this->Tenants->Locations->find('list', ['limit' => 200]);
        $programs = $this->Tenants->Programs->find('listGrouped', ['limit' => 200]);
        $this->set(compact('tenant', 'locations', 'programs'));
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

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tenant could not be saved. Please, try again.'));
        }
        $locations = $this->Tenants->Locations->find('list', ['limit' => 200]);
        $programs = $this->Tenants->Programs->find('listGrouped', ['limit' => 200]);
        $this->set(compact('tenant', 'locations', 'programs'));
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

    /**
     * View method
     *
     * @param string|null $id Tenant id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function viewUsers($id = null)
    {
        $tenant = $this->Tenants->get($id, [
            'contain' => [
                'Programs' => [
                    'Areas',
                ],
                'Locations',
                'TenantFilters' => [
                    'AppUsers' => function ($q) {
                        return $q->where([
                            'AppUsers.active' => true,
                            'AppUsers.role IN' => UserRole::getGroup(UserRole::GROUP_STAFF),
                        ]);
                    },
                ],
            ],
        ]);

        $this->set(compact('tenant'));
    }

    public function deleteUser($tenantFilterId)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tenantFilter = $this->Tenants->TenantFilters->get($tenantFilterId);
        if ($this->Tenants->TenantFilters->delete($tenantFilter)) {
            $this->Flash->success(__('The user has been removed.'));
        } else {
            $this->Flash->error(__('The user could not be removed. Please, try again.'));
        }

        return $this->redirect(['action' => 'viewUsers', $tenantFilter->tenant_id]);
    }

    public function addUser()
    {
        $tenantFilter = $this->Tenants->TenantFilters->newEmptyEntity();
        if ($this->request->is('post')) {
            $tenantFilter = $this->Tenants->TenantFilters->patchEntity($tenantFilter, $this->request->getData());
            if ($this->Tenants->TenantFilters->save($tenantFilter)) {
                $this->Flash->success(__('The user has been added.'));

                return $this->redirect(['action' => 'viewUsers']);
            }
            $this->Flash->error(__('The user could not be added. Please, try again.'));
        }
        $appUsers = $this->Tenants->TenantFilters->AppUsers
            ->find('listLabel', ['limit' => 200])
            ->where([
                'AppUsers.active' => true,
                'AppUsers.role IN' => UserRole::getGroup(UserRole::GROUP_STAFF),
            ]);
        $tenants = $this->Tenants->find('listLabel', ['limit' => 200]);
        $this->set(compact('tenants', 'tenantFilter', 'appUsers'));
    }
}
