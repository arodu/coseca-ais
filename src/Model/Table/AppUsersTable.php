<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Table\Traits\BasicTableTrait;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use CakeDC\Users\Model\Table\UsersTable;

/**
 * @property \App\Model\Table\StudentsTable $Studens
 */

class AppUsersTable extends UsersTable
{
    use BasicTableTrait;

    public bool $isValidateEmail = true;

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
        $this->hasOne('CurrentStudent', [
            'className' => 'Students',
            'foreignKey' => 'user_id',
            'strategy' => 'select',
            'finder' => 'lastElement',
        ]);
    }

    /**
     * @param \Cake\Validation\Validator $validator
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator = parent::validationDefault($validator);

        $validator
            ->requirePresence('email', 'create')
            ->notEmptyString('email')
            ->add('email', 'valid', ['rule' => 'email']);

        return $validator;
    }

    /**
     * @param \Cake\ORM\RulesChecker $rules
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules = parent::buildRules($rules);

        $rules->add($rules->isUnique(['dni']), '_isUnique', [
            'errorField' => 'dni',
            'message' => __('El numero de Cedula ya esta registrado'),
        ]);

        return $rules;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterMarshal(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew() && $entity->isDirty('email')) {
            $entity->username = $entity->email;
        }
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findAuth(SelectQuery $query): SelectQuery
    {
        return $query
            ->find('active')
            ->contain([
                'CurrentStudent' => ['Tenants'],
            ]);
    }
}
