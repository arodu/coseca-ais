<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Lapse;
use App\Model\Table\Traits\BasicTableTrait;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Tenants Model
 *
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\HasMany $Lapses
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\HasMany $Students
 * @property \App\Model\Table\TenantFiltersTable&\Cake\ORM\Association\HasMany $TenantFilters
 *
 * @method \App\Model\Entity\Tenant newEmptyEntity()
 * @method \App\Model\Entity\Tenant newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Tenant get($primaryKey, $options = [])
 * @method \App\Model\Entity\Tenant findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Tenant patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Tenant|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Tenant[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class TenantsTable extends Table
{
    use BasicTableTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('tenants');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('Lapses', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('Students', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasMany('TenantFilters', [
            'foreignKey' => 'tenant_id',
        ]);
        $this->hasOne('CurrentLapse', [
            'className' => 'Lapses',
            'foreignKey' => 'tenant_id',
            'strategy' => 'select',
            'finder' => 'lastElement',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('abbr')
            ->maxLength('abbr', 100)
            ->requirePresence('abbr', 'create')
            ->notEmptyString('abbr');

        return $validator;
    }
}
