<?php
declare(strict_types=1);

namespace App\Controller\Admin\Stage;

use App\Controller\Admin\AppAdminController;
use App\Controller\Traits\Stage\AdscriptionsProcessTrait;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use Cake\Log\Log;
use CakeLteTools\Controller\Traits\RedirectLogicTrait;

/**
 * StudentAdscriptionsController Controller
 *
 * @property \App\Model\Table\StudentAdscriptionsTable $StudentAdscriptions
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AdscriptionsController extends AppAdminController
{
    use AdscriptionsProcessTrait;
    use RedirectLogicTrait;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->StudentStages = $this->fetchTable('StudentStages');
        $this->StudentAdscriptions = $this->fetchTable('StudentAdscriptions');
    }

    /**
     * Add method
     *
     * @param int|string|null $student_id Student id.
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($student_id = null)
    {
        $student = $this->StudentAdscriptions->Students->get($student_id);
        $student_adscription = $this->StudentAdscriptions->newEmptyEntity();
        if ($this->request->is('post')) {
            try {
                $this->StudentStages->getConnection()->begin();

                $student_adscription = $this->StudentAdscriptions->patchEntity($student_adscription, $this->request->getData());

                $adscriptions = $this->StudentAdscriptions->find()->where(['student_id' => $student_id])->toArray();
                if (empty($adscriptions)) {
                    $student_adscription->principal = true;
                }

                if ($student_adscription->principal) {
                    $this->StudentAdscriptions->updateAll(
                        ['principal' => false],
                        ['student_id' => $student_id]
                    );
                }

                $this->StudentAdscriptions->saveOrFail($student_adscription);

                $adscriptionStage = $this->StudentStages
                    ->find('byStudentStage', [
                        'student_id' => $student->id,
                        'stage' => StageField::ADSCRIPTION,
                    ])
                    ->first();
                $this->StudentStages->updateStatus($adscriptionStage, StageStatus::IN_PROGRESS);

                $this->StudentStages->getConnection()->commit();

                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['_name' => 'admin:student:view', $student_id]);
            } catch (\Exception $e) {
                $this->StudentStages->getConnection()->rollback();
                Log::error($e->getMessage());
                $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
            }
        }

        $institution_projects = $this->StudentAdscriptions->InstitutionProjects
            ->find('listForSelect', ['tenant_id' => $student->tenant_id]);
        $tutors = $this->StudentAdscriptions->Tutors
            ->find('list', ['limit' => 200])
            ->where(['Tutors.tenant_id' => $student->tenant_id]);
        $back = $this->getRedirectUrl();
        $this->set(compact('student', 'student_adscription', 'institution_projects', 'tutors', 'back'));
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
                'Tutors',
                'Students',
            ],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $adscription = $this->StudentAdscriptions->patchEntity($adscription, $this->request->getData());
            if ($this->StudentAdscriptions->save($adscription)) {
                $this->Flash->success(__('The student_adscription has been saved.'));

                return $this->redirect(['_name' => 'admin:student:adscriptions', $adscription->student_id]);
            }
            $this->Flash->error(__('The student_adscription could not be saved. Please, try again.'));
        }

        $tutors = $this->StudentAdscriptions->Tutors
            ->find('list', ['limit' => 200])
            ->where([
                'Tutors.tenant_id' => $adscription->student->tenant_id,
            ]);
        $student = $adscription->student;
        $institution_projects = $this->StudentAdscriptions->InstitutionProjects
            ->find('listForSelect', ['tenant_id' => $student->tenant_id]);
        $this->set(compact('adscription', 'tutors', 'student', 'institution_projects'));
    }

    /**
     * Delete method
     *
     * @param string $status StudentAdscription id.
     * @param int|string $id StudentAdscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function changeStatus($status, $id)
    {
        $this->request->allowMethod(['post', 'put']);

        $adscription = $this->processChangeStatus($status, $id);

        return $this->redirect(['controller' => 'Students', 'action' => 'adscriptions', $adscription->student_id, 'prefix' => 'Admin']);
    }

    /**
     * Set principal method
     *
     * @param string|null $id StudentAdscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function setPrincipal($id)
    {
        $this->request->allowMethod(['post', 'put']);

        $adscription = $this->StudentAdscriptions->get($id);

        $this->StudentAdscriptions->getConnection()->transactional(function () use ($adscription) {
            $this->StudentAdscriptions->updateAll(
                ['principal' => false],
                ['student_id' => $adscription->student_id]
            );

            $adscription->principal = true;
            $this->StudentAdscriptions->saveOrFail($adscription);
        });

        return $this->redirect(['_name' => 'admin:student:adscriptions', $adscription->student_id]);
    }

    /**
     * Cancel project
     * @param string|null $id StudentAdscription id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cancel($id)
    {
        $this->changeStatus('cancelled', $id);
    }
}
