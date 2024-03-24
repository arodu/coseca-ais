<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;
use Cake\Log\Log;

/**
 * Lapses Controller
 *
 * @property \App\Model\Table\LapsesTable $Lapses
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LapsesController extends AppAdminController
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('lapses');
    }

    /**
     * Add method
     *
     * @param string|null $tenant_id Tenant id.
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
        $tenant = $this->Lapses->Tenants
            ->find('complete')
            ->where(['Tenants.id' => $tenant_id])
            ->firstOrFail();
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

    /**
     * @param int|string $lapse_dates_id
     * @return \Cake\Http\Response|null|void
     */
    public function editDates($lapse_dates_id = null)
    {
        $lapse_date = $this->Lapses->LapseDates->get($lapse_dates_id, [
            'contain' => ['Lapses' => ['Tenants']],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lapse_date = $this->Lapses->LapseDates->patchEntity($lapse_date, $this->request->getData());
            if ($this->Lapses->LapseDates->save($lapse_date)) {
                $this->Flash->success(__('Date has been updated.'));

                return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $lapse_date->lapse->tenant_id, '?' => ['lapse_id' => $lapse_date->lapse_id]]);
            }
            $this->Flash->error(__('Date could not be updated. Please, try again.'));
        }

        $this->set(compact('lapse_date'));
    }

    /**
     * Change active method
     *
     * @param string|null $id Lapse id.
     * @param int $active Active value
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changeActive($id = null, $active = 0)
    {
        $this->request->allowMethod(['post', 'put']);

        try {
            $this->Lapses->getConnection()->begin();
            $lapse = $this->Lapses->get($id);

            $this->Lapses->updateAll(['active' => 0], ['tenant_id' => $lapse->tenant_id]);

            $lapse->active = (int)$active;
            $this->Lapses->saveOrFail($lapse);

            $this->Flash->success(__('The lapse has been updated.'));
            $this->Lapses->getConnection()->commit();
        } catch (\Exception $e) {
            $this->Lapses->getConnection()->rollback();
            $this->Flash->error(__('The lapse could not be updated. Please, try again.'));
            Log::error($e->getMessage());
        }

        return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $lapse->tenant_id, '?' => ['lapse_id' => $id]]);
    }

    /**
     * Add dates method
     *
     * @param string|null $id Lapse id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    public function addDates(string $id = null)
    {
        $lapse = $this->Lapses->get($id);
        $dates = $this->Lapses->LapseDates->defaultDatesEntities($lapse->id);

        if ($this->Lapses->LapseDates->saveMany($dates)) {
            $this->Flash->success(__('The lapse dates have been saved.'));
        } else {
            $this->Flash->error(__('The lapse dates could not be saved. Please, try again.'));
        }
        
        return $this->redirect(['controller' => 'Tenants', 'action' => 'view', $lapse->tenant_id, '?' => ['lapse_id' => $id]]);
    }
}
