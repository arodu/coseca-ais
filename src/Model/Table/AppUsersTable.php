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
        
        $this->hasMany('Students', [
            'foreignKey' => 'user_id',
        ]);
        $this->hasMany('TenantFilters', [
            'foreignKey' => 'user_id',
        ]);

        // @todo fix this, add finder
        $this->hasOne('CurrentStudent', [
            'className' => 'Students',
            'foreignKey' => 'user_id',
            'strategy' => 'select',
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
    public function findAuth(Query $query, array $options = []): Query
    {
        return $query
            ->find('active')
            //->find('withLastStudent')
            //->contain(['TenantFilters' => ['Tenants']])
            //->contain(['CurrentStudent' => ['Tenants']])
            ;
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findWithLastStudent(Query $query, array $options = []): Query
    {
        // @todo change to CurrentStudent logic

        $fields = array_merge(
            ['id', 'user_id', 'tenant_id', 'type', 'tenant'],
            $options['fields'] ?? [],
        );

        return $query->contain('Students', function (Query $q) use ($fields) {
            return $q
                //->select($fields)
                ->contain(['Tenants'])
                ->order([
                    'created' => 'DESC',
                ])
                ->limit(1);
        });
    }
}
