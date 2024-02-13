<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InterestAreas Model
 *
 * @property \App\Model\Table\ProgramsTable&\Cake\ORM\Association\BelongsTo $Programs
 * @method \App\Model\Entity\InterestArea newEmptyEntity()
 * @method \App\Model\Entity\InterestArea newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InterestArea[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InterestArea get($primaryKey, $options = [])
 * @method \App\Model\Entity\InterestArea findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InterestArea patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InterestArea[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InterestArea|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InterestArea saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InterestArea[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InterestArea[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InterestArea[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InterestArea[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InterestAreasTable extends Table
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

        $this->setTable('interest_areas');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Programs', [
            'foreignKey' => 'program_id',
            'joinType' => 'INNER',
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
            ->integer('program_id')
            ->notEmptyString('program_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

        $validator
            ->scalar('description')
            ->allowEmptyString('description');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn('program_id', 'Programs'), ['errorField' => 'program_id']);

        return $rules;
    }
}
