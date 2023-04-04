<?php

declare(strict_types=1);

namespace App\Controller\Stage;

use App\Controller\AppController;
use App\Controller\Traits\RedirectLogicTrait;
use Cake\Http\Exception\ForbiddenException;

/**
 * Tracking Controller
 *
 * @method \App\Model\Entity\Tracking[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TrackingController extends AppController
{
    use RedirectLogicTrait;

    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
        $this->Tracking = $this->fetchTable('StudentTracking');
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($adscription_id = null)
    {
        $this->request->allowMethod(['post']);

        $adscription = $this->Tracking->Adscriptions->get($adscription_id);

        if (!$this->Authorization->can($adscription, 'addTracking')) {
            $this->Flash->error(__('You are not authorized to add activity to this adscription.'));
            
            return $this->redirect($this->request->referer());
        }

        $tracking = $this->Tracking->newEntity($this->request->getData());

        if ($this->Tracking->save($tracking)) {
            $this->Flash->success(__('The tracking has been saved.'));   
        } else {
            $this->Flash->error(__('The tracking could not be saved. Please, try again.'));
        }

        return $this->redirect($this->request->referer());
    }

    /**
     * Delete method
     *
     * @param string|null $id Tracking id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tracking = $this->Tracking->get($id, [
            'contain' => ['Adscriptions'],
        ]);

        if (!$this->Authorization->can($tracking->adscription, 'deleteTracking')) {
            $this->Flash->error(__('You are not authorized to delete this activity.'));
            
            return $this->redirect($this->request->referer());
        }

        if ($this->Tracking->delete($tracking)) {
            $this->Flash->success(__('The tracking has been deleted.'));
        } else {
            $this->Flash->error(__('The tracking could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->request->referer());
    }

    public function close($adscriptiond_id = null)
    {

        return $this->redirect($this->request->referer());
    }
}
