<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\AppUser;
use App\Model\Entity\Student;
use App\Model\Field\StageField;
use App\Model\Field\StageStatus;
use App\Model\Field\StudentType;
use App\Model\Table\Traits\BasicTableTrait;
use App\Utility\Calc;
use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\Log\Log;
use Cake\ORM\Query;
use Cake\ORM\Query\SelectQuery;
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
        $this->addBehavior('FilterTenant');

        $this->addBehavior('LastElement', [
            'fieldGroup' => 'user_id',
            'subQueryConditions' => [
                $this->aliasField('active') => true,
            ],
        ]);

        $this->belongsTo('AppUsers', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER',
            'finder' => 'withPrograms',
        ]);
        $this->belongsTo('Lapses', [
            'foreignKey' => 'lapse_id',
            'joinType' => 'LEFT',
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
        $this->hasMany('StudentAdscriptions', [
            'foreignKey' => 'student_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasOne('PrincipalAdscription', [
            'className' => 'StudentAdscriptions',
            'foreignKey' => 'student_id',
            'finder' => 'principal',
        ]);
        $this->hasOne('StudentCourses', [
            'foreignKey' => 'student_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);

        $this->loadQueryFilters();
    }

    /**
     * @param \Cake\Validation\Validator $validator
     * @return \Cake\Validation\Validator
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

    /**
     * @return void
     */
    public function loadQueryFilters()
    {
        $this->addFilterField('tenant_id', [
            'tableField' => $this->aliasField('tenant_id'),
            'finder' => QueryFilterPlugin::FINDER_SELECT,
        ]);
        $this->addFilterField('dni', [
            'tableField' => $this->AppUsers->aliasField('dni'),
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
            'finder' => function (SelectQuery $query, array $options = []) {
                $lapses_ids = $this->Lapses
                    ->find('list', ['valueField' => 'id'])
                    ->where([$this->Lapses->aliasField('name') => $options['value']]);

                return $query
                    ->where(
                        [$this->aliasField('lapse_id') . ' IN' => $lapses_ids]
                    );
            },
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findLastStageFilter(SelectQuery $query, array $options = []): SelectQuery
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
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithTenants(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query->contain([
            'Tenants' => [
                'CurrentLapse' => [
                    'LapseDates',
                ],
            ],
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithStudentAdscriptions(SelectQuery $query, array $options = []): SelectQuery
    {
        return $query->contain([
            'StudentAdscriptions' => function (SelectQuery $query) use ($options) {
                if (isset($options['status']) && is_array($options['status'])) {
                    $query->where(['StudentAdscriptions.status IN' => $options['status']]);
                }

                return $query->contain([
                    'InstitutionProjects' => ['Institutions'],
                    'Tutors',
                    'StudentDocuments',
                ]);
            },
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithStudentCourses(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'StudentCourses',
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithAppUsers(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'AppUsers',
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithStudentData(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'StudentData' => [
                'InterestAreas',
            ],
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithLapses(SelectQuery $query): SelectQuery
    {
        return $query->contain([
            'Lapses' => [
                'LapseDates',
            ],
        ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findLoadProgress(SelectQuery $query, array $options = []): SelectQuery
    {
        if (empty($options['studentStages'])) {
            return $query;
        }

        $studentStages = $options['studentStages'];

        $query = $query->find('withLapses');

        $stageRegister = $studentStages[StageField::REGISTER->value] ?? null;

        // stage: registy, status: in-progress
        if (!empty($stageRegister) && $stageRegister->getStatus()->is([StageStatus::IN_PROGRESS])) {
            $query = $query
                ->find('withTenants');
        }

        // stage: registy, status: success
        if (!empty($stageRegister) && $stageRegister->getStatus()->is([StageStatus::SUCCESS])) {
            $query = $query
                ->contain(['Tenants' => ['Programs']])
                ->find('withStudentData')
                ->find('withAppUsers');
        }

        return $query;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if (!$entity->isNew() && empty($entity->lapse_id)) {
            $currentLapse = $this->Tenants->CurrentLapse
                ->find()
                ->where(['CurrentLapse.tenant_id' => $entity->tenant_id])
                ->first();

            $entity->lapse_id = $currentLapse->id;
        }
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $this->StudentStages->create([
                'student_id' => $entity->id,
                'stage' => StageField::default()->value,
            ]);
        }

        Cache::delete('student_info_' . $entity->id);
    }

    /**
     * @param \App\Model\Entity\AppUser $user
     * @param null $options
     * @return \App\Model\Entity\Student|null
     */
    public function newRegularStudent(AppUser $user, array $options = []): ?Student
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

        return $student;
    }

    /**
     * @param mixed $ids
     * @param \App\Model\Field\StageField $stageField
     * @param \App\Model\Field\StageStatus $stageStatus
     * @return int
     */
    public function closeLastStageMasive(mixed $ids, StageField $stageField, StageStatus $stageStatus): int
    {
        if (is_string($ids) || is_int($ids)) {
            $ids = [(int)$ids];
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

    /**
     * @param int $student_id
     * @return array
     */
    public function getStudentTrackingInfo(int $student_id): array
    {
        return Cache::remember('student_tracking_info_' . $student_id, function () use ($student_id) {
            $adscriptionsIds = $this->StudentAdscriptions->find('activeProjects', options: ['student_id' => $student_id]);

            return $this->getStudentTrackingInfoByAdscription($adscriptionsIds);
        }, '1day');
    }

    /**
     * @param array $adscriptionsIds
     * @return array
     */
    public function getStudentTrackingInfoByAdscription(array|SelectQuery $adscriptionsIds = []): array
    {
        $trackingCount = $this->StudentAdscriptions->StudentTracking->find()
            ->where(['StudentTracking.student_adscription_id IN' => $adscriptionsIds])
            ->count();

        $trackingFirstDate = null;
        $trackingLastDate = null;
        $totalHours = null;

        if ($trackingCount > 0) {
            $trackingFirstDate = $this->StudentAdscriptions->StudentTracking->find()
                ->select(['StudentTracking.date'])
                ->where(['StudentTracking.student_adscription_id IN' => $adscriptionsIds])
                ->order(['StudentTracking.date' => 'ASC'])
                ->first();

            $trackingLastDate = $this->StudentAdscriptions->StudentTracking->find()
                ->select(['StudentTracking.date'])
                ->where(['StudentTracking.student_adscription_id IN' => $adscriptionsIds])
                ->order(['StudentTracking.date' => 'DESC'])
                ->first();

            $totalHours = $this->StudentAdscriptions->StudentTracking->find()
                ->select(['total_hours' => 'SUM(StudentTracking.hours)'])
                ->where(['StudentTracking.student_adscription_id IN' => $adscriptionsIds])
                ->first();

            $totalPercent = Calc::percentHoursCompleted($totalHours->total_hours ?? 0);
        }

        return [
            'trackingCount' => $trackingCount ?? 0,
            'trackingFirstDate' => $trackingFirstDate->date ?? null,
            'trackingLastDate' => $trackingLastDate->date ?? null,
            'totalHours' => $totalHours->total_hours ?? 0,
            'totalPercent' => $totalPercent ?? 0,
        ];
    }

    /**
     * @param \App\Model\Entity\Student $student
     * @return \App\Model\Entity\Student
     */
    public function updateTotalHours(Student $student): Student
    {
        $adscriptionsIds = $this->StudentAdscriptions->find('activeProjects', options: ['student_id' => $student->id]);

        $totalHours = $this->StudentAdscriptions->StudentTracking->find()
            ->select(['total_hours' => 'SUM(StudentTracking.hours)'])
            ->where(['StudentTracking.student_adscription_id IN' => $adscriptionsIds])
            ->first();

        $student->total_hours = $totalHours->total_hours ?? 0;

        return $this->saveOrFail($student);
    }
}
