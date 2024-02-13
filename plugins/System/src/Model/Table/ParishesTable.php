<?php
declare(strict_types=1);

namespace System\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Parishes Model
 *
 * @method \System\Model\Entity\Parish newEmptyEntity()
 * @method \System\Model\Entity\Parish newEntity(array $data, array $options = [])
 * @method \System\Model\Entity\Parish[] newEntities(array $data, array $options = [])
 * @method \System\Model\Entity\Parish get($primaryKey, $options = [])
 * @method \System\Model\Entity\Parish findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \System\Model\Entity\Parish patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \System\Model\Entity\Parish[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \System\Model\Entity\Parish|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\Parish saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\Parish[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\Parish[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \System\Model\Entity\Parish[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\Parish[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class ParishesTable extends Table
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

        $this->setTable('sys_parishes');
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
            ->integer('municipality_id')
            ->requirePresence('municipality_id', 'create')
            ->notEmptyString('municipality_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        return $validator;
    }
}
