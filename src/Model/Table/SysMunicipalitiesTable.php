<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * SysMunicipalities Model
 *
 * @method \App\Model\Entity\SysMunicipality newEmptyEntity()
 * @method \App\Model\Entity\SysMunicipality newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\SysMunicipality[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\SysMunicipality get($primaryKey, $options = [])
 * @method \App\Model\Entity\SysMunicipality findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\SysMunicipality patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\SysMunicipality[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\SysMunicipality|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SysMunicipality saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\SysMunicipality[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysMunicipality[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysMunicipality[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\SysMunicipality[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class SysMunicipalitiesTable extends Table
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
