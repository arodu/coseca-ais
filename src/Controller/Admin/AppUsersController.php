<?php
declare(strict_types=1);

namespace App\Controller\Admin;

use App\Model\Field\UserRole;
use Cake\Event\EventInterface;
use Cake\ORM\Query;

class AppUsersController extends AppAdminController
{
    /**
     * @inheritDoc
     */
    public function beforeRender(EventInterface $event)
    {
        $this->MenuLte->activeItem('users');
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function index()
    {
        $this->paginate = [];

        $query = $this->AppUsers->find()
            ->where([
                'AppUsers.role IN' => UserRole::getGroup(UserRole::GROUP_ADMIN),
            ]);

        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * @param int|string|null $id
     * @return \Cake\Http\Response|null|void
     */
    public function view($id = null)
    {
        $user = $this->AppUsers->get($id, [
            'contain' => [
                'TenantFilters' => [
                    'Tenants' => function (Query $q) {
                        return $q->applyOptions(['skipFilterTenant' => true]);
                    },
                ],
                'SocialAccounts',
            ],
        ]);

        $this->set(compact('user'));
    }

    /**
     * @return \Cake\Http\Response|null|void
     */
    public function add()
    {
        $user = $this->AppUsers->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->AppUsers->patchEntity($user, $this->request->getData());
            if ($this->AppUsers->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * @param int|string|null $id
     * @return \Cake\Http\Response|null|void
     */
    public function edit($id = null)
    {
        $user = $this->AppUsers->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->AppUsers->patchEntity($user, $this->request->getData());
            if ($this->AppUsers->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * @param int|string|null $id
     * @return \Cake\Http\Response|null|void
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->AppUsers->get($id);
        if ($this->AppUsers->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
