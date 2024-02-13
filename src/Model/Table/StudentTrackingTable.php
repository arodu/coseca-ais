<?php

declare(strict_types=1);

namespace App\Model\Table;

use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StudentTracking Model
 *
 * @property \App\Model\Table\StudentAdscriptionsTable&\Cake\ORM\Association\BelongsTo $Adscriptions
 * @method \App\Model\Entity\StudentTracking newEmptyEntity()
 * @method \App\Model\Entity\StudentTracking newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StudentTracking[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentTracking get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentTracking findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StudentTracking patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentTracking[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentTracking|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentTracking saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentTracking[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentTrackingTable extends Table
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

        $this->setTable('student_tracking');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsTo('Adscriptions', [
            'className' => 'StudentAdscriptions',
            'foreignKey' => 'student_adscription_id',
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
            ->integer('student_adscription_id')
            ->notEmptyString('student_adscription_id');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        $validator
            ->numeric('hours')
            ->requirePresence('hours', 'create')
            ->notEmptyString('hours');

        $validator
            ->scalar('description')
            ->maxLength('description', 255)
            ->requirePresence('description', 'create')
            ->notEmptyString('description');

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
        $rules->add($rules->existsIn('student_adscription_id', 'Adscriptions'), ['errorField' => 'student_adscription_id']);

        return $rules;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->updateStudentTotalHours($entity);
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        $this->updateStudentTotalHours($entity);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $entity
     * @return void
     */
    protected function updateStudentTotalHours(EntityInterface $entity)
    {
        $student = $this->Adscriptions->get(
            $entity->student_adscription_id,
            contain: ['Students']
        )->student;

        $this->Adscriptions->Students->updateTotalHours($student);

        Cache::delete('student_tracking_info_' . $student->id);
    }
}
