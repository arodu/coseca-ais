<?php
declare(strict_types=1);

namespace App\Controller\Stage;

use App\Controller\AppController;

/**
 * Tracking Controller
 *
 * @method \App\Model\Entity\Tracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $tracking = $this->paginate($this->Tracking);

        $this->set(compact('tracking'));
    }

    /**
     * View method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tracking = $this->Tracking->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('tracking'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tracking = $this->Tracking->newEmptyEntity();
        if ($this->request->is('post')) {
            $tracking = $this->Tracking->patchEntity($tracking, $this->request->getData());
            if ($this->Tracking->save($tracking)) {
                $this->Flash->success(__('The tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tracking could not be saved. Please, try again.'));
        }
        $this->set(compact('tracking'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tracking = $this->Tracking->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tracking = $this->Tracking->patchEntity($tracking, $this->request->getData());
            if ($this->Tracking->save($tracking)) {
                $this->Flash->success(__('The tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tracking could not be saved. Please, try again.'));
        }
        $this->set(compact('tracking'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tracking = $this->Tracking->get($id);
        if ($this->Tracking->delete($tracking)) {
            $this->Flash->success(__('The tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
