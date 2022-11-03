<?php
declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use CakeDC\Users\Model\Table\UsersTable;

/**
 * @property \App\Model\Table\StudentsTable $Studens
 */

class AppUsersTable extends UsersTable
{
    use BasicTableTrait;

    /**
     * @param array $config
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);
        
        $this->hasOne('Students', [
            'foreignKey' => 'user_id',
        ]);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     * @return void
     */
    public function afterMarshal(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && $entity->isDirty('email')) {
            $entity->username = $entity->email;
        }
    }

    /**
     * @param Query $query
     * @param array $options
     * @return void
     */
    public function findAuth(Query $query, array $options = [])
    {
        return $query->find('active')->contain([
            'Students' => [
                'fields' => ['id'],
            ]
        ]);
    }
}
