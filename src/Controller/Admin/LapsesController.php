<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Lapses Controller
 *
 * @property \App\Model\Table\LapsesTable $Lapses
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LapsesController extends AppAdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $lapses = $this->paginate($this->Lapses);

        $this->set(compact('lapses'));
    }

    /**
     * View method
     *
     * @param string|null $id Lapse id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $lapse = $this->Lapses->get($id, [
            'contain' => ['StudentStages'],
        ]);

        $this->set(compact('lapse'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $lapse = $this->Lapses->newEmptyEntity();
        if ($this->request->is('post')) {
            $lapse = $this->Lapses->patchEntity($lapse, $this->request->getData());
            if ($this->Lapses->save($lapse)) {
                $this->Flash->success(__('The lapse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lapse could not be saved. Please, try again.'));
        }
        $this->set(compact('lapse'));
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
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $lapse = $this->Lapses->patchEntity($lapse, $this->request->getData());
            if ($this->Lapses->save($lapse)) {
                $this->Flash->success(__('The lapse has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The lapse could not be saved. Please, try again.'));
        }
        $this->set(compact('lapse'));
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

        return $this->redirect(['action' => 'index']);
    }
}
