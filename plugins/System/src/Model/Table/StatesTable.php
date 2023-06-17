<?php
declare(strict_types=1);

namespace System\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * States Model
 *
 * @method \System\Model\Entity\State newEmptyEntity()
 * @method \System\Model\Entity\State newEntity(array $data, array $options = [])
 * @method \System\Model\Entity\State[] newEntities(array $data, array $options = [])
 * @method \System\Model\Entity\State get($primaryKey, $options = [])
 * @method \System\Model\Entity\State findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \System\Model\Entity\State patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \System\Model\Entity\State[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \System\Model\Entity\State|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\State saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \System\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\State[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StatesTable extends Table
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

        $this->setTable('sys_states');
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
            ->scalar('name')
            ->maxLength('name', 250)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('iso')
            ->maxLength('iso', 4)
            ->requirePresence('iso', 'create')
            ->notEmptyString('iso');

        return $validator;
    }
}
