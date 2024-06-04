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
            ->contain([
                'TenantFilters' => [
                    'Tenants' => [
                        'finder' => 'complete',
                    ],
                ],
            ])
            ->where([
                'AppUsers.role IN' => UserRole::getGroup(UserRole::GROUP_STAFF),
                'AppUsers.id IN' => $this->AppUsers->TenantFilters->find()->select(['user_id']),
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
}
