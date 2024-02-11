<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * InstitutionProjectsTable Model
 *
 * @property \App\Model\Table\InstitutionsTable&\Cake\ORM\Association\BelongsTo $Institutions
 * @property \App\Model\Table\StudentAdscriptionsTable&\Cake\ORM\Association\HasMany $StudentAdscriptions
 * @method \App\Model\Entity\InstitutionProject newEmptyEntity()
 * @method \App\Model\Entity\InstitutionProject newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\InstitutionProject[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\InstitutionProject get($primaryKey, $options = [])
 * @method \App\Model\Entity\InstitutionProject findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\InstitutionProject patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\InstitutionProject[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\InstitutionProject|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstitutionProject saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\InstitutionProject[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InstitutionProject[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\InstitutionProject[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\InstitutionProject[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InstitutionProjectsTable extends Table
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

        $this->setTable('institution_projects');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Institutions', [
            'foreignKey' => 'institution_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('StudentAdscriptions', [
            'foreignKey' => 'institution_project_id',
        ]);
        $this->belongsTo('InterestAreas', [
            'foreignKey' => 'interest_area_id',
            'joinType' => 'LEFT',
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
            ->integer('institution_id')
            ->notEmptyString('institution_id');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->requirePresence('name', 'create')
            ->notEmptyString('name');

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
        $rules->add($rules->existsIn('institution_id', 'Institutions'), ['errorField' => 'institution_id']);

        return $rules;
    }
}
