<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */

namespace App\Controller;

use App\Model\Field\UserRole;
use Cake\Log\Log;
use Throwable;

/**
 * Static content controller
 *
 * This controller will render views from templates/Pages/
 *
 * @link https://book.cakephp.org/4/en/controllers/pages-controller.html
 */
class PagesController extends AppController
{
    /**
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');

        $this->Authentication->allowUnauthenticated(['home']);
    }

    /**
     * @return void
     */
    public function home()
    {
        try {
            $identity = $this->Authentication->getIdentity();

            if (!$identity) {
                return $this->redirect('/login');
            }

            if (in_array($identity->role, UserRole::getAdminGroup())) {
                return $this->redirect(['_name' => 'admin:home']);
            }

            if (in_array($identity->role, UserRole::getStudentGroup())) {
                return $this->redirect(['_name' => 'student:home']);
            }
        } catch (Throwable $e) {
            Log::alert($e->getMessage());
        }

        return $this->redirect('/login');
    }
}
