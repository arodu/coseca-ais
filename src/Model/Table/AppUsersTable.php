<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Field\Users;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use CakeDC\Users\Model\Table\UsersTable;

/**
 * @property \App\Model\Table\StudentsTable $Studens
 */

class AppUsersTable extends UsersTable
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->hasOne('Students', [
            'foreignKey' => 'user_id',
        ]);
    }

    public function afterMarshal(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $entity->username = $entity->email;
        }
    }
}
