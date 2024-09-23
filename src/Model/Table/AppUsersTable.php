<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\AppUser;
use App\Model\Field\UserRole;
use App\Model\Table\Traits\BasicTableTrait;
use App\Utility\FilterTenantUtility;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\Validation\Validator;
use CakeDC\Users\Model\Table\UsersTable;

/**
 * @property \App\Model\Table\StudentsTable $Studens
 */

class AppUsersTable extends UsersTable
{
    use BasicTableTrait;

    public $isValidateEmail = true;

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
     * @param \Cake\Event\EventInterface $event
     * @param \App\Model\Entity\AppUser $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterSave(EventInterface $event, AppUser $entity, ArrayObject $options)
    {
        if ($entity->isNew() && $entity->enum('role')->isGroup(UserRole::GROUP_STUDENT)) {
            $this->CurrentStudent->newRegularStudent($entity);
        }
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findAuth(Query $query, array $options = []): Query
    {
        if (!empty($options['id'])) {
            $query->where([$this->aliasField('id') => $options['id']]);
        }

        return $query
            ->find('active')
            ->contain([
                'CurrentStudent' => ['Tenants'],
            ]);
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findListLabel(Query $query, array $options = []): Query
    {
        return $query
            ->find('list', array_merge([
                'keyField' => 'id',
                'valueField' => 'label_name',
            ], $options));
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findByTenants(Query $query, array $options = []): Query
    {
        if (empty($options['tenant_ids'])) {
            $options['tenant_ids'] = FilterTenantUtility::read();
        }

        return $query->where([
            $this->aliasField('id') . ' IN' => $this->TenantFilters->find()
                ->select(['user_id'])
                ->where(['tenant_id IN' => $options['tenant_ids']]),
        ]);
    }

    /**
     * @param \Cake\ORM\Query $query
     * @param array $options
     * @return \Cake\ORM\Query
     */
    public function findOnlyStaff(Query $query, array $options = []): Query
    {
        return $query->where([
            $this->aliasField('role') . ' IN' => UserRole::getGroup(UserRole::GROUP_STAFF),
        ]);
    }
}
