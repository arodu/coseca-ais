<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Model\Field\StageField;
use Cake\ORM\Query;

/**
 * StudentAdscriptionsController Controller
 *
 * @property \App\Model\Table\StudentAdscriptionsTable $StudentAdscriptions
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdscriptionsController extends AppAdminController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->StudentAdscriptions = $this->fetchTable('StudentAdscriptions');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($student_id = null)
    {
        $student = $this->StudentAdscriptions->Students->get($student_id, [
            'contain' => [
                'StudentStages' => function($query) {
                    return $query->where([
                        'stage' => StageField::ADSCRIPTION->value,
                    ]);
                }
            ]
        ]);
        $student_adscription = $this->StudentAdscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $student_adscription = $this->StudentAdscriptions->patchEntity($student_adscription, $this->request->getData());
            if ($this->StudentAdscriptions->save($student_adscription)) {
                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['_name' => 'admin:student_view', $student_id]);
            }
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }

        dd($student);


        $institution_projects = $this->StudentAdscriptions->InstitutionProjects->find('list', ['limit' => 200])->all();


        // $lapse_id = 


        $tutors = $this->StudentAdscriptions->Tutors->find('list', ['limit' => 200])->all();


        $this->set(compact('student_id', 'student_adscription', 'institution_projects', 'lapses', 'tutors'));
    }

    /**
     * Edit method
     *
     * @param string|null $id StudentAdscription id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $student_adscription = $this->StudentAdscriptions->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $student_adscription = $this->StudentAdscriptions->patchEntity($student_adscription, $this->request->getData());
            if ($this->StudentAdscriptions->save($student_adscription)) {
                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }
        $students = $this->StudentAdscriptions->Students->find('list', ['limit' => 200])->all();
        $institution_projects = $this->StudentAdscriptions->InstitutionProjects->find('list', ['limit' => 200])->all();
        $lapses = $this->StudentAdscriptions->Lapses->find('list', ['limit' => 200])->all();
        $tutors = $this->StudentAdscriptions->Tutors->find('list', ['limit' => 200])->all();
        $this->set(compact('student_adscription', 'students', 'institution_projects', 'lapses', 'tutors'));
    }

    /**
     * Delete method
     *
     * @param string|null $id StudentAdscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $student_adscription = $this->StudentAdscriptions->get($id);
        if ($this->StudentAdscriptions->delete($student_adscription)) {
            $this->Flash->success(__('The student_adscription has been deleted.'));
        } else {
            $this->Flash->error(__('The student_adscription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
