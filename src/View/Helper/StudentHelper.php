<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\AppUser;
use App\Model\Entity\Student;
use App\Model\Entity\Tenant;
use Cake\View\Helper;
use Cake\View\View;

/**
 * Student helper
 */
class StudentHelper extends Helper
{
    /**
     * Default configuration.
     *
     * @var array<string, mixed>
     */
    protected $_defaultConfig = [];

    protected Student $_student;

    public $helpers = ['Identity'];

    public function initialize(array $config): void
    {
        $this->_student = $this->Identity->get('current_student');
    }

    public function get(): Student
    {
        return $this->_student;
    }

    public function getUser(): AppUser
    {
        return $this->Identity->get();
    }
}
