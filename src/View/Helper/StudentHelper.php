<?php
declare(strict_types=1);

namespace App\View\Helper;

use App\Model\Entity\AppUser;
use App\Model\Entity\Student;
use Cake\View\Helper;

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
    protected array $_defaultConfig = [];

    /**
     * @var \App\Model\Entity\Student
     */
    protected Student $_student;

    /**
     * @var array
     */
    public array $helpers = ['Identity'];

    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        $this->_student = $this->Identity->get('current_student');
    }

    /**
     * @return \App\Model\Entity\Student
     */
    public function get(): Student
    {
        return $this->_student;
    }

    /**
     * @return \App\Model\Entity\AppUser
     */
    public function getUser(): AppUser
    {
        return $this->Identity->get();
    }
}
