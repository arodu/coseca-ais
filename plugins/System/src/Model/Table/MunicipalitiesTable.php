<?php
declare(strict_types=1);

namespace System\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Municipalities Model
 *
 * @method \System\Model\Entity\Municipality newEmptyEntity()
 * @method \System\Model\Entity\Municipality newEntity(array $data, array $options = [])
 * @method \System\Model\Entity\Municipality[] newEntities(array $data, array $options = [])
 * @method \System\Model\Entity\Municipality get($primaryKey, $options = [])
 * @method \System\Model\Entity\Municipality findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \System\Model\Entity\Municipality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \System\Model\Entity\Municipality[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \System\Model\Entity\Municipality|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\Municipality saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\Municipality[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\Municipality[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \System\Model\Entity\Municipality[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\Municipality[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class MunicipalitiesTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('sys_municipalities');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');
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
            ->integer('state_id')
            ->requirePresence('state_id', 'create')
            ->notEmptyString('state_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 100)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
