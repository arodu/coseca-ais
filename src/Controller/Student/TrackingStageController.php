<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Model\Field\AdscriptionStatus;
use Cake\View\CellTrait;

/**
 * StudentTracking Controller
 *
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingStageController extends AppStudentController
{
    use CellTrait;


    public function initialize(): void
    {
        parent::initialize();
        $this->Students = $this->fetchTable('Students');
        $this->StudentTracking = $this->fetchTable('StudentTracking');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $student_id = $this->getCurrentStudent()->id;
        $trackingView = $this->cell('TrackingView', ['student_id' => $student_id]);
        $this->set(compact('student_id', 'trackingView'));
    }

    /**
     * View method
     *
     * @param string|null $id Student Tracking id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function view($id = null)
    {
        $studentTracking = $this->StudentTracking->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('studentTracking'));
    }
    */

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    /*
    public function add()
    {
        $studentTracking = $this->StudentTracking->newEmptyEntity();
        if ($this->request->is('post')) {
            $studentTracking = $this->StudentTracking->patchEntity($studentTracking, $this->request->getData());
            if ($this->StudentTracking->save($studentTracking)) {
                $this->Flash->success(__('The student tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }
        $this->set(compact('studentTracking'));
    }
    */

    /**
     * Edit method
     *
     * @param string|null $id Student Tracking id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function edit($id = null)
    {
        $studentTracking = $this->StudentTracking->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $studentTracking = $this->StudentTracking->patchEntity($studentTracking, $this->request->getData());
            if ($this->StudentTracking->save($studentTracking)) {
                $this->Flash->success(__('The student tracking has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The student tracking could not be saved. Please, try again.'));
        }
        $this->set(compact('studentTracking'));
    }
    */

    /**
     * Delete method
     *
     * @param string|null $id Student Tracking id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    /*
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $studentTracking = $this->StudentTracking->get($id);
        if ($this->StudentTracking->delete($studentTracking)) {
            $this->Flash->success(__('The student tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The student tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
    */
}
