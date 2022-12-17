<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\AppController;

/**
 * Courses Controller
 *
 * @property \App\Model\Table\StudentCoursesTable $StudentCourses
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CoursesController extends AppController
{
    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $studentCourse = $this->StudentCourses->newEmptyEntity();
        if ($this->request->is('post')) {
            $studentCourse = $this->StudentCourses->patchEntity($studentCourse, $this->request->getData());
            if ($this->StudentCourses->save($studentCourse)) {
                $this->Flash->success(__('The student course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student course could not be saved. Please, try again.'));
        }
        $students = $this->StudentCourses->Students->find('list', ['limit' => 200])->all();
        $this->set(compact('studentCourse', 'students'));
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
                $this->Flash->success(__('The student course has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student course could not be saved. Please, try again.'));
        }
        $students = $this->StudentCourses->Students->find('list', ['limit' => 200])->all();
        $this->set(compact('studentCourse', 'students'));
    }
}
