<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\AdscriptionStatus;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\View\CellTrait;
use CakeLteTools\Controller\Traits\BulkActionsTrait;
use CakeLteTools\Controller\Traits\ExportDataTrait;

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
    use CellTrait;

    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
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
                'Tenants.abbr', 'AppUsers.dni', 'AppUsers.first_name', 'AppUsers.last_name', 'LastStage.lapse.name', 'LastStage.stage',
            ],
        ];

        $query = $this->Students
            ->find()
            ->contain([
                'AppUsers',
                'Tenants' => ['Programs', 'Locations'],
                'LastStage',
                'Lapses',
            ]);

        $filterKey = 'f';

        $formData = $this->getRequest()->getQuery() ?? $this->getRequest()->getData() ?? [];
        $query = $this->Students->queryFilter($query, $formData[$filterKey] ?? []);

        if (isset($formData['export']) && $formData['export'] == 'csv') {
            return $this->queryToCsv($query);
        }

        $students = $this->paginate($query);
        $isFiltered = $this->Students->queryWasFiltered();

        $formFilters = $this->cell('Filters::adminStudents', [
            'isFiltered' => $isFiltered,
            'filterKey' => $filterKey,
        ]);

        $this->set(compact('students', 'formFilters'));
    }

    /**
     * @param \Cake\ORM\Query $query
     * @return \Cake\Http\Response|null|void
     */
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
            'student_data.phone' => __('Telefono'),
            'student_data.uc' => __('UC'),
            'student_data.gender' => __('Genero'),
            'lapse.name' => __('Lapso'),
            'last_stage.stage_label' => __('Etapa'),
            'last_stage.status_label' => __('Estatus'),
            'student_data.interest_area.name' => __('Area de Interes'),
        ], [
            'filename' => $this->filenameWithDate('estudiantes'),
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
            ->find('withAppUsers')
            ->where(['Students.id' => $id])
            ->first();

        $stageList = $this->Students->StudentStages->find('stageList', ['student' => $student]);

        $this->set(compact('student', 'stageList'));
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function info($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['AppUsers', 'StudentData' => ['InterestAreas'], 'Tenants' => ['Programs']],

        ]);

        $this->set(compact('student'));
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function adscriptions($id = null)
    {
        $student = $this->Students->find('withStudentAdscriptions')
            ->where(['Students.id' => $id])
            ->first();

        $this->set(compact('student'));
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function settings($id = null)
    {
        $student = $this->Students->get($id, [
            'contain' => ['AppUsers'],
        ]);

        $this->set(compact('student'));
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function tracking($id = null)
    {
        $student = $this->Students->get($id);
        $trackingView = $this->cell('TrackingView', [
            'student_id' => $student->id,
            'urlList' => [
                'add' => ['_name' => 'admin:stage:tracking:add'],
                'delete' => ['_name' => 'admin:stage:tracking:delete'],
                'validate' => [
                    '_name' => 'admin:stage:adscription:changeStatus',
                    // @todo poder poner claves en este array, revisar en rutas
                    AdscriptionStatus::VALIDATED->value,
                ],
                'close' => [
                    '_name' => 'admin:stage:adscription:changeStatus',
                    AdscriptionStatus::CLOSED->value,
                ],
            ],
        ]);

        $this->set(compact('trackingView', 'student'));
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
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
     * @param array $ids
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

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
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

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function newProgram(string $id)
    {
        $this->request->allowMethod(['post', 'put']);

        try {
            $this->Students->getConnection()->begin();
            $student = $this->Students->get($id, [
                'contain' => ['AppUsers'],
            ]);
            $student->active = false;
            $this->Students->saveOrFail($student);

            $newStudent = $this->Students->newEntity([
                'user_id' => $student->user_id,
                'tenant_id' => $this->request->getData('tenant_id'),
                'type' => StudentType::REGULAR->value,
            ]);

            $this->Students->saveOrFail($newStudent);
            $this->Students->getConnection()->commit();
            $this->Flash->success(__('A new student record has been created, and the previous one has been deactivated.'));

            return $this->redirect(['action' => 'view', $newStudent->id]);
        } catch (\Exception $e) {
            $this->Flash->error(__('The student could not be saved. Please, try again.'));

            $this->Students->getConnection()->rollback();
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function deactivate(string $id)
    {
        $this->request->allowMethod(['post', 'put']);
        $student = $this->Students->get($id);
        $student->active = false;
        if ($this->Students->save($student)) {
            $this->Flash->success(__('The student has been deactivate'));
        } else {
            $this->Flash->error(__('The student could not be deactivate. Please, try again.'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }

    /**
     * @param int|string $id
     * @return \Cake\Http\Response|null|void
     */
    public function reactivate(string $id)
    {
        $this->request->allowMethod(['post', 'put']);
        $student = $this->Students->get($id);
        $student->active = true;
        if ($this->Students->save($student)) {
            $this->Flash->success(__('The student has been activate'));
        } else {
            $this->Flash->error(__('The student could not be activate. Please, try again.'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }
}
