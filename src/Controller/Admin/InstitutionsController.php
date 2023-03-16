<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Traits\SysActionsTrait;
use Cake\Event\EventInterface;

/**
 * Institutions Controller
 *
 * @property \App\Model\Table\InstitutionsTable $Institutions
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstitutionsController extends AppAdminController
{
    use SysActionsTrait;

    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('institutions');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Tenants'],
        ];

        $query = $this->Institutions->find();

        // filterLogic
        $formData = $this->getRequest()->getQuery();
        if (!empty($formData)) {
            $query = $this->Institutions->queryFilter($query, $formData);
        }
        $filtered = $this->Institutions->queryWasFiltered();
        $tenants = $this->Institutions->Tenants->find('list');
        // /filterLogic

        $institutions = $this->paginate($query);

        $this->set(compact('institutions', 'filtered', 'tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $institution = $this->Institutions->get($id, [
            'contain' => ['Tenants', 'InstitutionProjects'],
        ]);

        $this->set(compact('institution'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $institution = $this->Institutions->newEmptyEntity();
        if ($this->request->is('post')) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $tenants = $this->Institutions->Tenants->find('list', ['limit' => 200])->all();
        $states = $this->Institutions->States->find('list', ['limit' => 200])->all();
        $this->set(compact('institution', 'tenants', 'states'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $institution = $this->Institutions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $tenants = $this->Institutions->Tenants->find('list', ['limit' => 200])->all();
        $this->set(compact('institution', 'tenants'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Institution id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $institution = $this->Institutions->get($id);
        if ($this->Institutions->delete($institution)) {
            $this->Flash->success(__('The institution has been deleted.'));
        } else {
            $this->Flash->error(__('The institution could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
