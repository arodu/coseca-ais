<?php

declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\ActionValidateTrait;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Utility\Stages;
use Cake\I18n\FrozenDate;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\StudentCoursesTable $StudentCourses
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppAdminController
{
    use ActionValidateTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->StudentCourses = $this->fetchTable('StudentCourses');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($student_id = null)
    {
        $studentCourse = $this->StudentCourses->newEmptyEntity();
        $session = $this->getRequest()->getSession();
        if ($this->request->is('post')) {
            $studentCourse = $this->StudentCourses->patchEntity($studentCourse, $this->request->getData());
            if ($this->StudentCourses->save($studentCourse)) {
                $session->write('courseSelectedDate', $studentCourse->date);
                $this->Flash->success(__('The student course has been saved.'));

                if (
                    $this->actionValidate()
                    && $nextStage = Stages::closeStudentStage((int) $student_id, StageField::COURSE, StageStatus::SUCCESS)
                ) {
                    $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
                }

                return $this->redirect(['_name' => 'admin:student_view', $student_id]);
            }
            $this->Flash->error(__('The student course could not be saved. Please, try again.'));
        }
        $selectedDate = $session->read('courseSelectedDate', FrozenDate::now());
        $this->set(compact('studentCourse', 'selectedDate', 'student_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Student Course id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $studentCourse = $this->StudentCourses->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentCourse = $this->StudentCourses->patchEntity($studentCourse, $this->request->getData());
            if ($this->StudentCourses->save($studentCourse)) {
                $session = $this->getRequest()->getSession();
                $session->write('courseSelectedDate', $studentCourse->date);
                $this->Flash->success(__('The student course has been saved.'));

                if (
                    $this->actionValidate()
                    && $nextStage = Stages::closeStudentStage((int) $studentCourse->student_id, StageField::COURSE, StageStatus::SUCCESS)
                ) {
                    $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
                }

                return $this->redirect(['_name' => 'admin:student_view', $studentCourse->student_id]);
            }
            $this->Flash->error(__('The student course could not be saved. Please, try again.'));
        }
        $students = $this->StudentCourses->Students->find('list', ['limit' => 200])->all();
        $this->set(compact('studentCourse', 'students'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student Course id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentCourse = $this->StudentCourses->get($id);
        if ($this->StudentCourses->delete($studentCourse)) {
            $this->Flash->success(__('The student course has been deleted.'));
        } else {
            $this->Flash->error(__('The student course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'admin:student_view', $studentCourse->student_id]);
    }
}
