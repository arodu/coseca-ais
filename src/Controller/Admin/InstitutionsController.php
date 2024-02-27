<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use Cake\Event\EventInterface;

/**
 * Institutions Controller
 *
 * @property \App\Model\Table\InstitutionsTable $Institutions
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class InstitutionsController extends AppAdminController
{
    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event): void
    {
        $this->MenuLte->activeItem('institutions');
    }

    /**
     * Index method
     *
     * @return void Renders view
     */
    public function index(): void
    {
        $this->paginate = [
            'order' => ['Institutions.name' => 'ASC'],
        ];

        $query = $this->Institutions->find()->contain(['Tenants']);

        // filterLogic
        $formData = $this->getRequest()->getQuery();
        if (!empty($formData)) {
            $query = $this->Institutions->queryFilter($query, $formData);
        }
        $filtered = $this->Institutions->queryWasFiltered();
        $tenants = $this->Institutions->Tenants->find('listLabel');
        // /filterLogic

        $institutions = $this->paginate($query);

        $this->set(compact('institutions', 'filtered', 'tenants'));
    }

    /**
     * View method
     *
     * @param string|null $id Institution id.
     * @return void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view(?string $id = null): void
    {
        $institution = $this->Institutions->get($id, contain: [
            'Tenants',
            'InstitutionProjects' => ['InterestAreas'],
            'States',
            'Municipalities',
            'Parishes',
        ]);

        $this->set(compact('institution'));
    }

    /**
     * Add method
     *
     * @return void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $institution = $this->Institutions->newEmptyEntity();
        if ($this->request->is('post')) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'view', $institution->id]);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $tenants = $this->Institutions->Tenants->find('listLabel', ['limit' => 200])->all();
        $this->set(compact('institution', 'tenants'));
    }

    /**
     * @param string|int $id
     * @return void
     */
    public function addProject(int|string|null $id = null)
    {
        $institution = $this->Institutions->get($id, contain: ['Tenants']);
        $institutionProject = $this->Institutions->InstitutionProjects->newEmptyEntity();
        if ($this->request->is('post')) {
            $institutionProject = $this->Institutions->InstitutionProjects->patchEntity($institutionProject, $this->request->getData());
            $institutionProject->institution_id = $id;
            if ($this->Institutions->InstitutionProjects->save($institutionProject)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'view', $institutionProject->institution_id]);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $interestAreas = $this->Institutions->InstitutionProjects->InterestAreas->find('list', ['limit' => 200])
            ->where(['InterestAreas.program_id' => $institution->tenant->program_id])
            ->all();

        $this->set(compact('institution', 'institutionProject', 'interestAreas'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Institution id.
     * @return void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit(?string $id = null)
    {
        $institution = $this->Institutions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $institution = $this->Institutions->patchEntity($institution, $this->request->getData());
            if ($this->Institutions->save($institution)) {
                $this->Flash->success(__('The institution has been saved.'));

                return $this->redirect(['action' => 'view', $id]);
            }
            $this->Flash->error(__('The institution could not be saved. Please, try again.'));
        }
        $tenants = $this->Institutions->Tenants->find('listLabel', options: ['limit' => 200])->all();
        $this->set(compact('institution', 'tenants'));
    }

    /**
     * @param string|int $project_id
     * @return void
     */
    public function editProject(int|string|null $project_id = null)
    {
        $institutionProject = $this->Institutions->InstitutionProjects->get($project_id);
        $institution = $this->Institutions->get($institutionProject->institution_id, contain: ['Tenants']);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $institutionProject = $this->Institutions->InstitutionProjects->patchEntity($institutionProject, $this->request->getData());
            if ($this->Institutions->InstitutionProjects->save($institutionProject)) {
                $this->Flash->success(__('The project has been saved.'));

                return $this->redirect(['action' => 'view', $institutionProject->institution_id]);
            }
            $this->Flash->error(__('The project could not be saved. Please, try again.'));
        }
        $interestAreas = $this->Institutions->InstitutionProjects->InterestAreas->find('list', ['limit' => 200])
            ->where(['InterestAreas.program_id' => $institution->tenant->program_id])
            ->all();

        $this->set(compact('institution', 'institutionProject', 'interestAreas'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Institution id.
     * @return void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $institution = $this->Institutions->get($id);
        if ($this->Institutions->delete($institution)) {
            $this->Flash->success(__('The institution has been deleted.'));
        } else {
            $this->Flash->error(__('The institution could not be deleted. Please, try again.'));

            return $this->redirect(['action' => 'view', $id]);
        }

        return $this->redirect(['action' => 'index']);
    }
}
