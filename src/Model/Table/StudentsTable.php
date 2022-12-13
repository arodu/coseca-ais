<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\AppUser;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Table\Traits\BasicTableTrait;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Utility\Hash;
use Cake\Validation\Validator;
use InvalidArgumentException;
use QueryFilter\QueryFilterPlugin;

/**
 * Students Model
 *
 * @property \App\Model\Table\AppUsersTable&\Cake\ORM\Association\BelongsTo $AppUsers
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\StudentStagesTable&\Cake\ORM\Association\HasMany $StudentStages
 * @property \App\Model\Table\StudentStagesTable&\Cake\ORM\Association\HasOne $LastStage
 *
 * @method \App\Model\Entity\Student newEmptyEntity()
 * @method \App\Model\Entity\Student newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Student[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Student get($primaryKey, $options = [])
 * @method \App\Model\Entity\Student findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Student patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Student[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Student|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Student[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class StudentsTable extends Table
{
    use BasicTableTrait;

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('students');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('QueryFilter.QueryFilter');
        $this->addBehavior('Timestamp');
        $this->addBehavior('Muffin/Footprint.Footprint');

        $this->addBehavior('LastElement', [
            'fieldGroup' => 'user_id',
        ]);

        $this->belongsTo('AppUsers', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('StudentStages', [
            'foreignKey' => 'student_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasOne('LastStage', [
            'className' => 'StudentStages',
            'foreignKey' => 'student_id',
            'strategy' => 'select',
            'finder' => 'lastElement',
        ]);
        $this->hasOne('StudentData', [
            'foreignKey' => 'student_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('Adscriptions', [
            'foreignKey' => 'student_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->loadQueryFilters();
    }

    /**
     * @param Validator $validator
     * @return Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->uuid('user_id')
            ->notEmptyString('user_id');

        $validator
            ->integer('tenant_id')
            ->notEmptyString('tenant_id');

        $validator
            ->scalar('type')
            ->maxLength('type', 255)
            ->notEmptyString('type');

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
        $rules->add($rules->existsIn('user_id', 'AppUsers'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('tenant_id', 'Tenants'), ['errorField' => 'tenant_id']);

        return $rules;
    }

    public function loadQueryFilters()
    {
        $this->addFilterField('tenant_id', [
            'tableField' => $this->aliasField('tenant_id'),
            'finder' => QueryFilterPlugin::FINDER_SELECT,
        ]);
        $this->addFilterField('dni', [
            'tableField' => $this->aliasField('dni'),
            'finder' => QueryFilterPlugin::FINDER_EQUAL,
        ]);
        $this->addFilterField('names', [
            'tableField' => [$this->AppUsers->aliasField('first_name'), $this->AppUsers->aliasField('last_name')],
            'finder' => QueryFilterPlugin::FINDER_STRING,
        ]);
        $this->addFilterField('stage', [
            'tableField' => 'stage',
            'finder' => 'lastStageFilter',
        ]);
        $this->addFilterField('status', [
            'tableField' => 'status',
            'finder' => 'lastStageFilter',
        ]);
        $this->addFilterField('lapse', [
            'finder' => function (Query $query, array $options = []) {
                $lapses_ids = $this->StudentStages->Lapses
                    ->find('list', ['valueField' => 'id'])
                    ->where([$this->StudentStages->Lapses->aliasField('name') => $options['value']]);

                return $query->find('lastStageFilter', [
                    'tableField' => $this->LastStage->aliasField('lapse_id') . ' IN',
                    'value' => $lapses_ids,
                ]);
            }
        ]);
    }

    public function findLastStageFilter(Query $query, array $options = []): Query
    {
        if (empty($options['tableField'])) {
            throw new InvalidArgumentException('param tableField is necessary on options');
        }

        $subQuery = $this->LastStage->find()
            ->select([$this->LastStage->aliasField('student_id')])
            ->where([$options['tableField'] => $options['value']]);

        return $query->where([$this->aliasField('id') . ' IN' => $subQuery]);
    }

    /**
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findComplete(Query $query, array $options): Query
    {
        return $query->contain(['AppUsers']);
    }

    /**
     * @param EventInterface $event
     * @param EntityInterface $entity
     * @param ArrayObject $options
     * @return void
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $this->StudentStages->create([
                'student_id' => $entity->id,
                'stage' => StageField::default()->value,
                'lapse_id' => $this->Tenants->getCurrentLapse($entity->tenant_id)->id,
            ]);
        }
    }

    /**
     * @param AppUser $user
     * @param integer|null $tenant_id
     * @return void
     */
    public function newRegularStudent(AppUser $user, array $options = [])
    {
        $data = array_merge([
            'user_id' => $user->id,
            'tenant_id' => Hash::get($user, 'tenant_filters.0.tenant_id'),
            'type' => StudentType::REGULAR->value,
        ], $options);

        $student = $this->newEntity($data);

        if (!$this->save($student)) {
            Log::warning('student already exists');
        }
    }

    public function closeLastStageMasive(mixed $ids, StageField $stageField, StageStatus $stageStatus): int
    {
        if (is_string($ids) || is_int($ids)) {
            $ids = [$ids];
        }

        $studentStages = $this->StudentStages
            ->find('lastElement')
            ->where([
                'StudentStages.student_id IN' => $ids,
                'StudentStages.stage' => $stageField->value,
            ]);

        $affectedRows = 0;
        foreach ($studentStages as $student) {
            $lasStageField = $student->last_stage->getStageField();
            if ($lasStageField == $stageField) {
                // @todo refactor this
                // $student->last_stage->getStageInstance()->close($stageStatus);
                $affectedRows++;
            }
        }

        return $affectedRows;
    }
}
