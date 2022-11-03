<?php
declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AppController;
use App\Model\Entity\AppUser;

class AppStudentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
    }

    /**
     * @return AppUser
     */
    public function getAuthUser(): AppUser
    {
        $user = $this->Authentication->getIdentity()->getOriginalData();

        if (empty($user->student)) {
            return $this->reloadAuthUserStudent();
        }

        return $user;
    }

    /**
     * @return AppUser
     */
    public function reloadAuthUserStudent(): AppUser
    {
        $appUsersTable = $this->fetchTable('AppUsers');
        $user = $this->Authentication->getIdentity()->getOriginalData();
        if (empty($user->student)) {
            $student = $appUsersTable->Students->newEntity(['user_id' => $user->id]);
            $appUsersTable->Students->save($student);
        }

        $user = $appUsersTable->find('auth')->first();
        $this->Authentication->setIdentity($user);

        return $user;
    }
}
