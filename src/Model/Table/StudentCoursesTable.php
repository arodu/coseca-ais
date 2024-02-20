<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentCourses Model
 *
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\BelongsTo $Students
 * @method \App\Model\Entity\StudentCourse newEmptyEntity()
 * @method \App\Model\Entity\StudentCourse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StudentCourse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentCourse get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentCourse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StudentCourse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentCourse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentCourse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentCourse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentCourse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class StudentCoursesTable extends Table
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

        $this->setTable('student_courses');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
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
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->scalar('comment')
            ->allowEmptyString('comment');

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

        return $rules;
    }
}
