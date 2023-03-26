<?php

declare(strict_types=1);

namespace App\Controller\Admin;

use App\Controller\Traits\BulkActionsTrait;
use App\Controller\Traits\ExportDataTrait;
use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Event\EventInterface;
use Cake\ORM\Query;

/**
 * Students Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class StudentsController extends AppAdminController
{
    use BulkActionsTrait;
    use ExportDataTrait;

    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('students');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'sortableFields' => [
                'Tenants.abbr', 'dni', 'AppUsers.first_name', 'AppUsers.last_name', 'LastStage.lapse.name', 'LastStage.stage',
            ],
        ];

        $query = $this->Students
            ->find()
            ->contain(['AppUsers', 'Tenants', 'LastStage', 'Lapses']);

        // filterLogic
        $formData = $this->getRequest()->getQuery();

        if (!empty($formData)) {
            $query = $this->Students->queryFilter($query, $formData);
        }

        if (isset($formData['export']) && $formData['export'] == 'csv') {
            return $this->queryToCsv($query);
        }

        $filtered = $this->Students->queryWasFiltered();
        $tenants = $this->Students->Tenants->find('list');
        $lapses = $this->Students->Lapses->find('list', [
            'keyField' => 'name',
            'valueField' => 'name',
        ]);
        // /filterLogic
        
        $students = $this->paginate($query);

        $this->set(compact('students', 'filtered', 'tenants', 'lapses'));
    }

    protected function queryToCsv(Query $query)
    {
        $query = $query->contain([
            'StudentData' => ['InterestAreas'],
        ]);

        return $this->exportCsv($query->all()->toArray(), [
            'tenant.program.name' => __('Programa'),
            'tenant.name' => __('Sede'),
            'type_label' => __('Tipo'),
            'dni' => __('Cedula'),
            'first_name' => __('Nombres'),
            'last_name' => __('Apellidos'),
            'app_user.email' => __('Email'),
            'student_data.uc' => __('UC'),
            'student_data.gender' => __('Genero'),
            'lapse.name' => __('Lapso'),
            'last_stage.stage_label' => __('Etapa'),
            'last_stage.status_label' => __('Estatus'),
            'student_data.interest_area.name' => __('Area de Interes'),
        ], [
            'filename' => 'estudiantes.csv',
        ]);
    }


    /**
     * View method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $student = $this->Students
            ->find('withStudentAdscriptions')
            ->find('withStudentCourses')
            ->where(['Students.id' => $id])
            ->first();

        $stageList = $this->Students->StudentStages->find('stageList', ['student' => $student]);

        $this->set(compact('student', 'stageList'));
    }

    public function info($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['AppUsers', 'StudentData' => ['InterestAreas']],
        ]);

        $this->set(compact('student'));
    }

    public function adscriptions($id = null)
    {
        $student = $this->Students->find('withStudentAdscriptions')
            ->where(['Students.id' => $id])
            ->first();

        $this->set(compact('student'));
    }

    public function settings($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['AppUsers', 'StudentData'],
        ]);

        $this->set(compact('student'));
    }

    public function tracking($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => [
                'Lapses' => [
                    'LapseDates',
                ],
                'StudentAdscriptions' => [
                    'StudentTracking' => [
                        'sort' => ['StudentTracking.date' => 'ASC'],
                    ],
                    'InstitutionProjects' => [
                        'Institutions',
                    ],
                ]
            ],
        ]);
        $adscriptionsList = $this->Students->StudentAdscriptions->find('listOpen', ['student_id' => $id])->toArray();
        $trackingInfo = $this->Students->getStudentTrackingInfo($student->id);

        $this->set(compact('student', 'adscriptionsList', 'trackingInfo'));
    }

    public function prints($id = null)
    {
        $this->set('student_id', $id);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $student = $this->Students->newEmptyEntity();
        if ($this->request->is('post')) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }
        $appUsers = $this->Students->AppUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('student', 'appUsers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student could not be saved. Please, try again.'));
        }
        $appUsers = $this->Students->AppUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('student', 'appUsers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student = $this->Students->get($id);
        if ($this->Students->delete($student)) {
            $this->Flash->success(__('The student has been deleted.'));
        } else {
            $this->Flash->error(__('The student could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * @param array $items
     * @param array|null $redirect
     * @return \Cake\Http\Response|null|void Redirects to index.
     */
    protected function closeStageCourse(array $ids = [])
    {
        if (empty($ids)) {
            $this->Flash->warning(__('No se han seleccionado estudiantes'));
            return $this->redirect(['action' => 'index']);
        }

        $affectedRows = $this->Students->closeLastStageMasive($ids, StageField::COURSE, StageStatus::SUCCESS);

        $this->Flash->success(__('Cantidad de registros actualizados: {0}', $affectedRows));

        return $this->redirect(['action' => 'index']);
    }

    public function changeEmail($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['AppUsers'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $student = $this->Students->patchEntity($student, $this->request->getData());
            if ($this->Students->save($student)) {
                $this->Flash->success(__('The student email has been saved.'));

                return $this->redirect(['action' => 'view', $student['id']]);
            }
            $this->Flash->error(__('The student email could not be saved. Please, try again.'));
        }
        $this->set(compact('student'));
    }
}
