<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Lapses Controller
 *
 * @property \App\Model\Table\LapsesTable $Lapses
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LapsesController extends AppAdminController
{
    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('lapses');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    /*
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants'],
        ];
        $lapses = $this->paginate($this->Lapses);

        $this->set(compact('lapses'));
    }
    */

    /**
     * View method
     *
     * @param string|null $id Lapse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $lapse = $this->Lapses->get($id, [
            'contain' => ['Tenants', 'LapseDates'],
        ]);

        $this->set(compact('lapse'));
    }
    */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($tenant_id)
    {
        $lapse = $this->Lapses->newEmptyEntity();
        if ($this->request->is('post')) {
            $lapse = $this->Lapses->patchEntity($lapse, $this->request->getData());
            if ($this->Lapses->save($lapse)) {
                $this->Flash->success(__('The lapse has been saved.'));

                return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $tenant_id]);
            }
            $this->Flash->error(__('The lapse could not be saved. Please, try again.'));
        }
        $tenant = $this->Lapses->Tenants->get($tenant_id);
        $this->set(compact('lapse', 'tenant'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Lapse id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $lapse = $this->Lapses->get($id, [
            'contain' => ['Tenants'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lapse = $this->Lapses->patchEntity($lapse, $this->request->getData());
            if ($this->Lapses->save($lapse)) {
                $this->Flash->success(__('The lapse has been saved.'));

                return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $lapse->tenant_id, '?' => ['lapse_id' => $id]]);
            }
            $this->Flash->error(__('The lapse could not be saved. Please, try again.'));
        }
        $this->set(compact('lapse'));
    }

    public function editDates($lapse_dates_id = null)
    {
        $lapse_date = $this->Lapses->LapseDates->get($lapse_dates_id, [
            'contain' => ['Lapses' => ['Tenants']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lapse_date = $this->Lapses->LapseDates->patchEntity($lapse_date, $this->request->getData());
            if ($this->Lapses->LapseDates->save($lapse_date)) {
                $this->Flash->success(__('Date has been updated.'));

                return $this->redirect(['action' => 'view', $lapse_date->lapse_id]);
            }
            $this->Flash->error(__('Date could not be updated. Please, try again.'));
        }

        $this->set(compact('lapse_date'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Lapse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $lapse = $this->Lapses->get($id);
        if ($this->Lapses->delete($lapse)) {
            $this->Flash->success(__('The lapse has been deleted.'));
        } else {
            $this->Flash->error(__('The lapse could not be deleted. Please, try again.'));
        }

        return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $lapse->tenant_id]);
    }
}
