<?php

declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * StudentStages Controller
 *
 * @property \App\Model\Table\StudentStagesTable $StudentStages
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentStagesController extends AppAdminController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    /*
    public function index()
    {
        $this->paginate = [
            'contain' => ['Students', 'Lapses'],
        ];
        $studentStages = $this->paginate($this->StudentStages);

        $this->set(compact('studentStages'));
    }
    */

    /**
     * View method
     *
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $studentStage = $this->StudentStages->get($id, [
            'contain' => ['Students', 'Lapses'],
        ]);

        $this->set(compact('studentStage'));
    }
    */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    /*
    public function add()
    {
        $studentStage = $this->StudentStages->newEmptyEntity();
        if ($this->request->is('post')) {
            $studentStage = $this->StudentStages->patchEntity($studentStage, $this->request->getData());
            if ($this->StudentStages->save($studentStage)) {
                $this->Flash->success(__('The student stage has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student stage could not be saved. Please, try again.'));
        }
        $students = $this->StudentStages->Students->find('list', ['limit' => 200])->all();
        $lapses = $this->StudentStages->Lapses->find('list', ['limit' => 200])->all();
        $this->set(compact('studentStage', 'students', 'lapses'));
    }
    */

    /**
     * Edit method
     *
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studentStage = $this->StudentStages->get($id, [
            'contain' => ['Students'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentStage = $this->StudentStages->patchEntity($studentStage, $this->request->getData());
            if ($this->StudentStages->save($studentStage)) {
                $this->Flash->success(__('The student stage has been saved.'));

                return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
            }
            $this->Flash->error(__('The student stage could not be saved. Please, try again.'));
        }
        $lapses = $this->StudentStages->Lapses
            ->find('list', ['limit' => 200])
            ->where(['Lapses.tenant_id' => $studentStage->student->tenant_id])
            ->all();
        $this->set(compact('studentStage', 'lapses'));
    }

    /**
     * Delete method
     *
     * @param string|null $id StudentStage id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentStage = $this->StudentStages->get($id);
        if ($this->StudentStages->delete($studentStage)) {
            $this->Flash->success(__('The student stage has been deleted.'));
        } else {
            $this->Flash->error(__('The student stage could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    */


    public function forcedClose($id = null)
    {
        $this->request->allowMethod(['patch', 'post', 'put']);
        $studentStage = $this->StudentStages->get($id);

        // @todo ejecutar cierre del stage

        $this->Flash->success(__('The student stage has been updated.'));

        return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
    }
}
