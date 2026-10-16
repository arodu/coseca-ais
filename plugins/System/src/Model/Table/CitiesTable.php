<?php
declare(strict_types=1);

namespace System\Model\Table;

use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Cities Model
 *
 * @method \System\Model\Entity\City newEmptyEntity()
 * @method \System\Model\Entity\City newEntity(array $data, array $options = [])
 * @method \System\Model\Entity\City[] newEntities(array $data, array $options = [])
 * @method \System\Model\Entity\City get($primaryKey, $options = [])
 * @method \System\Model\Entity\City findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \System\Model\Entity\City patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \System\Model\Entity\City[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \System\Model\Entity\City|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\City saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \System\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \System\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \System\Model\Entity\City[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CitiesTable extends Table
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

        $this->setTable('sys_cities');
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
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->integer('state_id')
            ->requirePresence('state_id', 'create')
            ->notEmptyString('state_id');

        $validator
            ->boolean('capital');

        return $validator;
    }
}
