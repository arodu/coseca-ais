<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentAdscriptions Model
 *
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\BelongsTo $Projects
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\BelongsTo $Lapses
 * @property \App\Model\Table\TutorsTable&\Cake\ORM\Association\BelongsTo $Tutors
 *
 * @method \App\Model\Entity\StudentAdscription newEmptyEntity()
 * @method \App\Model\Entity\StudentAdscription newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StudentAdscription[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentAdscription get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentAdscription findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StudentAdscription patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentAdscription[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentAdscription|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentAdscription saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentAdscription[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentAdscriptionsTable extends Table
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

        $this->setTable('student_adscriptions');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Projects', [
            'foreignKey' => 'project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Lapses', [
            'foreignKey' => 'lapse_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tutors', [
            'foreignKey' => 'tutor_id',
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
            ->integer('student_id')
            ->notEmptyString('student_id');

        $validator
            ->integer('project_id')
            ->notEmptyString('project_id');

        $validator
            ->integer('lapse_id')
            ->notEmptyString('lapse_id');

        $validator
            ->integer('tutor_id')
            ->notEmptyString('tutor_id');

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
        $rules->add($rules->existsIn('student_id', 'Students'), ['errorField' => 'student_id']);
        $rules->add($rules->existsIn('project_id', 'Projects'), ['errorField' => 'project_id']);
        $rules->add($rules->existsIn('lapse_id', 'Lapses'), ['errorField' => 'lapse_id']);
        $rules->add($rules->existsIn('tutor_id', 'Tutors'), ['errorField' => 'tutor_id']);

        return $rules;
    }
}
