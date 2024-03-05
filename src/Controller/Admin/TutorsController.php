<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Tutors Controller
 *
 * @property \App\Model\Table\TutorsTable $Tutors
 * @method \App\Model\Entity\Tutor[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TutorsController extends AppAdminController
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $this->MenuLte->activeItem('tutors');
    }

    /**
     * Index method
     *
     * @return void Renders view
     */
    public function index(): void
    {
        $this->paginate = [];

        $query = $this->Tutors->find()->contain(['Tenants']);

        // filterLogic
        $formData = $this->getRequest()->getQuery();
        if (!empty($formData)) {
            $query = $this->Tutors->queryFilter($query, $formData);
        }
        $filtered = $this->Tutors->queryWasFiltered();
        $tenants = $this->Tutors->Tenants->find('listLabel');
        // /filterLogic

        $tutors = $this->paginate($query);

        $this->set(compact('tutors', 'filtered', 'tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Tutor id.
     * @return void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $tutor = $this->Tutors->get($id, contain: ['Tenants', 'StudentAdscriptions']);

        $this->set(compact('tutor'));
    }

    /**
     * @return \Cake\Http\Response|null
     */
    public function add()
    {
        $tutor = $this->Tutors->newEmptyEntity();
        if ($this->request->is('post')) {
            $tutor = $this->Tutors->patchEntity($tutor, $this->request->getData());
            if ($this->Tutors->save($tutor)) {
                $this->Flash->success(__('The tutor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tutor could not be saved. Please, try again.'));
        }
        $tenants = $this->Tutors->Tenants->find('listLabel', options: ['limit' => 200])->all();
        $this->set(compact('tutor', 'tenants'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tutor id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $tutor = $this->Tutors->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tutor = $this->Tutors->patchEntity($tutor, $this->request->getData());
            if ($this->Tutors->save($tutor)) {
                $this->Flash->success(__('The tutor has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tutor could not be saved. Please, try again.'));
        }
        $tenants = $this->Tutors->Tenants->find('listLabel')->all();
        $this->set(compact('tutor', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tutor id.
     * @return \Cake\Http\Response|null
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $modalForm = $this->getRequest()->getAttribute('modalForm');
        if (empty($modalForm) || !$modalForm->isValid()) {
            $this->Flash->error(__('Checked invalid!'));

            return $this->redirect(['action' => 'index']);
        }

        $this->request->allowMethod(['post', 'delete']);
        $tutor = $this->Tutors->get($id);
        if ($this->Tutors->delete($tutor)) {
            $this->Flash->success(__('The tutor has been deleted.'));
        } else {
            $this->Flash->error(__('The tutor could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
