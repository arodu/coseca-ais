<?php

declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;

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
            'contain' => ['Lapses']
        ]);

        $student_adscription = $this->StudentAdscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            $student_adscription = $this->StudentAdscriptions->patchEntity($student_adscription, $this->request->getData());
            if ($this->StudentAdscriptions->save($student_adscription)) {
                $this->closeStudentStage($student->id, StageField::ADSCRIPTION, StageStatus::REVIEW);
                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['_name' => 'admin:student_view', $student_id]);
            }
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }

        $institution_projects = $this->StudentAdscriptions->InstitutionProjects
            ->find('list', [
                'groupField' => 'institution.name',
                'limit' => 200
            ])
            ->contain(['Institutions'])
            ->where([
                'Institutions.tenant_id' => $student->tenant_id,
            ]);

        $tutors = $this->StudentAdscriptions->Tutors
            ->find('list', ['limit' => 200])
            ->where([
                'Tutors.tenant_id' => $student->tenant_id,
            ]);

        $this->set(compact('student', 'student_adscription', 'institution_projects', 'tutors'));
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
        $adscription = $this->StudentAdscriptions->get($id, [
            'contain' => [
                'InstitutionProjects' => ['Institutions'],
                'Lapses',
                'Tutors',
                'Students'
            ],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $adscription = $this->StudentAdscriptions->patchEntity($adscription, $this->request->getData());
            if ($this->StudentAdscriptions->save($adscription)) {
                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['_name' => 'admin:student_view', $adscription->student_id]);
            }
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }

        $tutors = $this->StudentAdscriptions->Tutors
            ->find('list', ['limit' => 200])
            ->where([
                'Tutors.tenant_id' => $adscription->student->tenant_id,
            ]);

        $this->set(compact('adscription', 'tutors'));
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
        $adscription = $this->StudentAdscriptions->get($id);
        if ($this->StudentAdscriptions->delete($adscription)) {
            $this->Flash->success(__('The student_adscription has been deleted.'));
        } else {
            $this->Flash->error(__('The student_adscription could not be deleted. Please, try again.'));
        }

        return $this->redirect(['_name' => 'admin:student_view', $adscription->student_id]);
    }
}
