<?php

declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\ActionValidateTrait;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\I18n\FrozenDate;
use Cake\Log\Log;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\StudentsTable $Students
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppAdminController
{
    use ActionValidateTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
    }

    /**
     * @param int|string|null $student_id
     * @param int|string|null $id
     * @return \Cake\Http\Response|null|void
     */
    public function edit($student_id = null, $id = null)
    {
        $student = $this->Students->get($student_id);

        $courseStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student->id,
                'stage' => StageField::COURSE,
            ])
            ->first();

        if (empty($courseStage) || !$this->Authorization->can($courseStage, 'courseEdit')) {
            throw new ForbiddenException(__('You are not authorized to access that location'));
        }

        if (!empty($id)) {
            $studentCourse = $this->Students->StudentCourses->get($id);
        } else {
            $studentCourse = $this->Students->StudentCourses->newEmptyEntity();
        }

        $session = $this->getRequest()->getSession();

        if ($this->request->is(['post', 'put'])) {
            try {
                $this->Students->getConnection()->begin();

                $studentCourse = $this->Students->StudentCourses->patchEntity($studentCourse, $this->request->getData());
                $this->Students->StudentCourses->saveOrFail($studentCourse);
                $this->Students->StudentStages->updateStatus($courseStage, StageStatus::REVIEW);

                $this->Students->getConnection()->commit();
                $success = true;

                $this->Flash->success(__('The student course has been saved.'));

                return $this->redirect(['_name' => 'admin:student:view', $student->id]);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                $this->Students->getConnection()->rollback();
                $this->Flash->error(__('The student course could not be saved. Please, try again.'));
            }
        }

        $selectedDate = $session->read('courseSelectedDate', FrozenDate::now());
        $this->set(compact('studentCourse', 'selectedDate', 'student'));
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
        $studentCourse = $this->Students->StudentCourses->get($id);
        if ($this->Students->StudentCourses->delete($studentCourse)) {
            $this->Flash->success(__('The student course has been deleted.'));
        } else {
            $this->Flash->error(__('The student course could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'admin:student:view', $studentCourse->student_id]);
    }

    /**
     * @param int|string|null $student_id
     * @return \Cake\Http\Response|null|void
     */
    public function closeStage($student_id = null)
    {
        $this->request->allowMethod(['post', 'put']);
        $courseStage = $this->Students->StudentStages
            ->find('byStudentStage', [
                'student_id' => $student_id,
                'stage' => StageField::COURSE,
            ])
            ->firstOrFail();

        if (empty($courseStage) || !$this->Authorization->can($courseStage, 'close')) {
            throw new ForbiddenException(__('You are not authorized to access that location'));
        }

        $this->Students->StudentStages->updateStatus($courseStage, StageStatus::SUCCESS);
        $nextStage = $this->Students->StudentStages->createNext($courseStage);

        if (($nextStage ?? false)) {
            $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
        }

        return $this->redirect(['_name' => 'admin:student:view', $student_id]);
    }
}
