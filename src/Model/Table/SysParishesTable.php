<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SysParishes Model
 *
 * @method \App\Model\Entity\SysParish newEmptyEntity()
 * @method \App\Model\Entity\SysParish newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SysParish[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SysParish get($primaryKey, $options = [])
 * @method \App\Model\Entity\SysParish findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SysParish patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SysParish[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SysParish|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SysParish saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SysParish[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysParish[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysParish[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysParish[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SysParishesTable extends Table
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
