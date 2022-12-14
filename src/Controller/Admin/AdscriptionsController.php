<?php
declare(strict_types=1);

namespace App\Controller\Admin;

/**
 * Adscriptions Controller
 *
 * @property \App\Model\Table\AdscriptionsTable $Adscriptions
 * @method \App\Model\Entity\Adscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdscriptionsController extends AppAdminController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($student_stage_id = null)
    {
        $studentStage = $this->StudentStages->get($student_stage_id);

        $adscription = $this->Adscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $adscription = $this->Adscriptions->patchEntity($adscription, $this->request->getData());
            if ($this->Adscriptions->save($adscription)) {
                $this->Flash->success(__('The adscription has been saved.'));

                return $this->redirect(['controller' => 'Students', 'action' => 'view', $studentStage->student_id]);
            }
            $this->Flash->error(__('The adscription could not be saved. Please, try again.'));
        }
        $projects = $this->Adscriptions->Projects->find('list', ['limit' => 200])->all();
        $lapses = $this->Adscriptions->Lapses->find('list', ['limit' => 200])->all();
        $tutors = $this->Adscriptions->Tutors->find('list', ['limit' => 200])->all();
        $this->set(compact('studentStage', 'adscription', 'projects', 'lapses', 'tutors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Adscription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $adscription = $this->Adscriptions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $adscription = $this->Adscriptions->patchEntity($adscription, $this->request->getData());
            if ($this->Adscriptions->save($adscription)) {
                $this->Flash->success(__('The adscription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The adscription could not be saved. Please, try again.'));
        }
        $students = $this->Adscriptions->Students->find('list', ['limit' => 200])->all();
        $projects = $this->Adscriptions->Projects->find('list', ['limit' => 200])->all();
        $lapses = $this->Adscriptions->Lapses->find('list', ['limit' => 200])->all();
        $tutors = $this->Adscriptions->Tutors->find('list', ['limit' => 200])->all();
        $this->set(compact('adscription', 'students', 'projects', 'lapses', 'tutors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Adscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $adscription = $this->Adscriptions->get($id);
        if ($this->Adscriptions->delete($adscription)) {
            $this->Flash->success(__('The adscription has been deleted.'));
        } else {
            $this->Flash->error(__('The adscription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
