<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\ActionValidateTrait;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Http\Exception\ForbiddenException;
use Cake\Http\Response;
use Cake\I18n\Date;
use Cake\Log\Log;
use Exception;

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
     * @param string|int|null $student_id
     * @param string|int|null $id
     * @return \Cake\Http\Response|null|void
     */
    public function edit(int|string|null $student_id = null, int|string|null $id = null): Response|null|null
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

                if ($this->actionValidate()) {
                    if (!$this->Authorization->can($courseStage, 'courseValidate')) {
                        throw new ForbiddenException(__('You are not authorized to access that location'));
                    }

                    $this->Students->StudentStages->updateStatus($courseStage, StageStatus::SUCCESS);
                    $nextStage = $this->Students->StudentStages->createNext($courseStage);
                }

                $this->Students->getConnection()->commit();
                $success = true;

                $this->Flash->success(__('The student course has been saved.'));
                if (($nextStage ?? false)) {
                    $this->Flash->success(__('The {0} stage has been created.', $nextStage->stage));
                }

                return $this->redirect(['_name' => 'admin:student:view', $student->id]);
            } catch (Exception $e) {
                Log::error($e->getMessage());
                $this->Students->getConnection()->rollback();
                $this->Flash->error(__('The student course could not be saved. Please, try again.'));
            }
        }

        $selectedDate = $session->read('courseSelectedDate', Date::now());
        $this->set(compact('studentCourse', 'selectedDate', 'student'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Student Course id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete(?string $id = null): Response|null|null
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
}
