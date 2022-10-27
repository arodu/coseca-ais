<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Stages Model
 *
 * @property \App\Model\Table\StudentStagesTable&\Cake\ORM\Association\HasMany $StudentStages
 *
 * @method \App\Model\Entity\Stage newEmptyEntity()
 * @method \App\Model\Entity\Stage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Stage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Stage get($primaryKey, $options = [])
 * @method \App\Model\Entity\Stage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Stage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Stage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Stage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Stage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StagesTable extends Table
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

        $this->setTable('stages');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('StudentStages', [
            'foreignKey' => 'stage_id',
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
            ->integer('position')
            ->requirePresence('position', 'create')
            ->notEmptyString('position');

        $validator
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->scalar('code')
            ->maxLength('code', 255)
            ->requirePresence('code', 'create')
            ->notEmptyString('code');

        return $validator;
    }
}
