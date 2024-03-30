<?php

declare(strict_types=1);

namespace Manager\Controller;

use App\Model\Table\AreasTable;
use Cake\Event\EventInterface;
use Cake\Utility\Text;
use Manager\Controller\AppController;
use System\Controller\Traits\TrashTrait;

/**
 * Areas Controller
 *
 * @method \Manager\Model\Entity\Area[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AreasController extends AppController
{
    use TrashTrait;

    protected AreasTable $Areas;

    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->Areas = $this->fetchTable('Areas');
        $this->loadComponent('System.Trash', [
            'model' => $this->Areas,
            'items' => 'areas',
        ]);
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @return void
     */
    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->MenuLte->activeItem('areas');
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $areas = $this->paginate($this->Areas);

        $this->set(compact('areas'));
    }

    /**
     * View method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $area = $this->Areas->get($id, [
            'contain' => [
                'Programs' => [
                    'Tenants' => [
                        'Locations',
                    ],
                ],
            ],
        ]);

        $this->set(compact('area'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $area = $this->Areas->newEmptyEntity();
        if ($this->request->is('post')) {
            try {
                $this->Areas->getConnection()->begin();
                $area = $this->Areas->patchEntity($area, $this->request->getData());

                $this->Areas->saveOrFail($area);
                $this->Flash->success(__('The area has been saved.'));
                $this->Areas->getConnection()->commit();

                return $this->redirect(['action' => 'index']);
            } catch (\Exception $e) {
                $this->Areas->getConnection()->rollback();
                $this->Flash->error(__('The area could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('area'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $area = $this->Areas->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $this->Areas->getConnection()->begin();
                $area = $this->Areas->patchEntity($area, $this->request->getData());

                $this->Areas->saveOrFail($area);
                $this->Flash->success(__('The area has been saved.'));
                $this->Areas->getConnection()->commit();

                return $this->redirect(['action' => 'view', $area->id]);
            } catch (\Exception $e) {
                $this->Areas->getConnection()->rollback();
                $this->Flash->error(__('The area could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('area'));
    }

    public function editLogo($id = null)
    {
        $area = $this->Areas->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            try {
                $this->Areas->getConnection()->begin();
                $logo = $this->request->getData('logo');

                if ($logo->getError() !== UPLOAD_ERR_OK) {
                    $area->setError('logo', 'The logo could not be uploaded.');
                    throw new \Exception('The logo could not be uploaded.');
                }

                // @todo move to a config file
                if ($logo->getSize() > 1024 * 1024) {
                    $area->setError('logo', 'The logo is too large.');
                    throw new \Exception('The logo is too large.');
                }

                $area = $this->Areas->patchEntity($area, $this->request->getData());
                $info = pathinfo($logo->getClientFilename());
                $filename = Text::slug($area->abbr) . '.' . $info['extension'];

                // @todo move patch to a config file
                $logo->moveTo(ROOT . DS . 'files' . DS . 'areas' . DS . $filename);
                $area->logo = DS . 'uploads' . DS . 'areas' . DS . $filename;

                $this->Areas->saveOrFail($area);
                $this->Flash->success(__('The area has been saved.'));
                $this->Areas->getConnection()->commit();

                return $this->redirect(['action' => 'view', $area->id]);
            } catch (\Exception $e) {
                $this->Areas->getConnection()->rollback();
                $this->Flash->error(__('The area could not be saved. Please, try again.'));
            }
        }
        $this->set(compact('area'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Area id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $area = $this->Areas->get($id);
        if ($this->Areas->delete($area)) {
            $this->Flash->success(__('The area has been deleted.'));
        } else {
            $this->Flash->error(__('The area could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
