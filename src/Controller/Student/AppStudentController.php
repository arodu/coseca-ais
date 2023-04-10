<?php

declare(strict_types=1);

namespace App\Controller\Student;

use App\Controller\AppController;
use App\Model\Entity\AppUser;
use App\Model\Entity\Student;

class AppStudentController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->loadComponent('Authorization.Authorization');
    }

    /**
     * @return Student
     */
    public function getCurrentStudent(): Student
    {
        return $this->getAuthUser()->current_student;
    }

    /**
     * @return AppUser
     */
    public function getAuthUser(): AppUser
    {
        $user = $this->Authentication->getIdentity()->getOriginalData();
        if (empty($user->current_student)) {
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

        if (empty($user->current_student)) {
            $appUsersTable->Students->newRegularStudent($user);
        }

        $user = $appUsersTable
            ->find('auth')
            ->where([$appUsersTable->aliasField('id') => $user->id])
            ->first();
        $this->Authentication->setIdentity($user);

        return $user;
    }
}
