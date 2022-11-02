<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\StudentStage;
use App\Model\Field\Stages;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * StudentStages Model
 *
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\BelongsTo $Lapses
 *
 * @method \App\Model\Entity\StudentStage newEmptyEntity()
 * @method \App\Model\Entity\StudentStage newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage get($primaryKey, $options = [])
 * @method \App\Model\Entity\StudentStage findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\StudentStage patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\StudentStage|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentStage saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\StudentStage[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentStagesTable extends Table
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

        $this->setTable('student_stages');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->belongsTo('Students', [
            'foreignKey' => 'student_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Lapses', [
            'foreignKey' => 'lapse_id',
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
            ->scalar('stage')
            ->maxLength('stage', 255)
            ->requirePresence('stage', 'create')
            ->notEmptyString('stage');

        $validator
            ->integer('lapse_id')
            ->notEmptyString('lapse_id');

        $validator
            ->scalar('status')
            ->maxLength('status', 255)
            ->requirePresence('status', 'create')
            ->notEmptyString('status');

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
        $rules->add($rules->isUnique(['student_id', 'stage'], 'This stage & student combination has already been used'));
        $rules->add($rules->existsIn('student_id', 'Students'), ['errorField' => 'student_id']);
        $rules->add($rules->existsIn('lapse_id', 'Lapses'), ['errorField' => 'lapse_id']);

        return $rules;
    }

    /**
     * @param array $options
     * @return StudentStage
     */
    public function create(array $options): StudentStage
    {
        if (empty($options['stage'])) {
            throw new InvalidArgumentException('param stage is necessary');
        }
        
        if (empty($options['student_id'])) {
            throw new InvalidArgumentException('param student_id is necessary');
        }

        if (empty($options['lapse_id'])) {
            $options['lapse_id'] = $this->Lapses->getCurrentLapse()->id ?? null;
        }

        if (empty($options['status'])) {
            $stageInfo = Stages::getStageInfo($options['stage']);
            $options['status'] = $stageInfo[Stages::DATA_STATUS] ?? Stages::STATUS_PENDING;
        }

        $studentStage = $this->newEntity($options);

        return $this->saveOrFail($studentStage);
    }

    /**
     * @param StudentStage $entity
     * @param string $newStatus
     * @return StudentStage
     */
    public function updateStatus(StudentStage $entity, string $newStatus): StudentStage
    {
        $entity->status = $newStatus;

        return $this->saveOrFail($entity);
    }

    /**
     * @param integer $student_id
     * @param string $stageKey
     * @return StudentStage
     */
    public function getByStudentStage(int $student_id, string $stageKey): StudentStage
    {
        return $this->find()->where([
                'student_id' => $student_id,
                'stage' => $stageKey,
            ])->first();
    }
}
