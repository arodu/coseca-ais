<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Field\AdscriptionStatus;
use ArrayObject;
use Cake\Cache\Cache;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\Query\SelectQuery;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use InvalidArgumentException;

/**
 * StudentAdscriptions Model
 *
 * @property \App\Model\Table\StudentsTable&\Cake\ORM\Association\BelongsTo $Students
 * @property \App\Model\Table\InstitutionProjectsTable&\Cake\ORM\Association\BelongsTo $InstitutionProjects
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\BelongsTo $Lapses
 * @property \App\Model\Table\TutorsTable&\Cake\ORM\Association\BelongsTo $Tutors
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
        $this->belongsTo('InstitutionProjects', [
            'foreignKey' => 'institution_project_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Tutors', [
            'foreignKey' => 'tutor_id',
            'joinType' => 'INNER',
        ]);
        $this->hasOne('StudentDocuments', [
            'foreignKey' => 'foreign_key',
            'conditions' => ['model' => 'StudentAdscriptions'],
            'dependent' => true,
            'cascadeCallbacks' => true,
        ]);
        $this->hasMany('StudentTracking', [
            'foreignKey' => 'student_adscription_id',
            'dependent' => true,
            'cascadeCallbacks' => true,
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
            ->integer('institution_project_id')
            ->notEmptyString('institution_project_id');

        $validator
            ->integer('lapse_id')
            ->notEmptyString('lapse_id');

        $validator
            ->integer('tutor_id')
            ->notEmptyString('tutor_id');

        $validator
            ->scalar('status')
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
        $rules->add($rules->existsIn('student_id', 'Students'), ['errorField' => 'student_id']);
        $rules->add($rules->existsIn('institution_project_id', 'InstitutionProjects'), ['errorField' => 'institution_project_id']);
        $rules->add($rules->existsIn('tutor_id', 'Tutors'), ['errorField' => 'tutor_id']);

        return $rules;
    }

    /**
     * @param \Cake\Event\EventInterface $event
     * @param \Cake\Datasource\EntityInterface $entity
     * @param \ArrayObject $options
     * @return void
     */
    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->isNew()) {
            $entity->status = $entity->status ?? AdscriptionStatus::PENDING->value;
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
        $this->updateStudentTotalHours($entity);
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
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findListOpen(SelectQuery $query, array $options): SelectQuery
    {
        if (empty($options['student_id'])) {
            throw new InvalidArgumentException('Missing student_id');
        }

        return $query
            ->find('list',
            keyField: 'id',
            valueField: 'institution_project.name',
            groupField: 'institution_project.institution.name')
            ->contain([
                'InstitutionProjects' => ['Institutions'],
            ])
            ->where([
                'student_id' => $options['student_id'],
                'status' => AdscriptionStatus::OPEN->value,
            ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findActiveProjects(SelectQuery $query, array $options): SelectQuery
    {
        if (empty($options['student_id'])) {
            throw new InvalidArgumentException('Missing student_id');
        }

        return $query
            ->select(['StudentAdscriptions.id'])
            ->where([
                'StudentAdscriptions.student_id' => $options['student_id'],
                'StudentAdscriptions.status IN' => AdscriptionStatus::getTrackablesValues(),
            ]);
    }

    /**
     * @param \Cake\Datasource\EntityInterface $entity
     * @return void
     */
    protected function updateStudentTotalHours(EntityInterface $entity)
    {
        $student = $this->get($entity->id, contain: ['Students'])->student;

        $this->Students->updateTotalHours($student);

        Cache::delete('student_tracking_info_' . $student->id);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithStudents(SelectQuery $query): SelectQuery
    {
        return $query
            ->contain([
                'Students' => [
                    'AppUsers',
                    'StudentData',
                    'Lapses',
                ],
            ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithInstitution(SelectQuery $query): SelectQuery
    {
        return $query
            ->contain([
                'InstitutionProjects' => ['Institutions'],
            ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithTracking(SelectQuery $query, array $options): SelectQuery
    {
        if (empty($options['sort'])) {
            $options['sort'] = 'ASC';
        }

        return $query
            ->contain([
                'StudentTracking' => [
                    'sort' => ['StudentTracking.date' => $options['sort']],
                ],
            ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findWithTutor(SelectQuery $query): SelectQuery
    {
        return $query
            ->contain([
                'Tutors',
            ]);
    }

    /**
     * @param \Cake\ORM\Query\SelectQuery $query
     * @param array $options
     * @return \Cake\ORM\Query\SelectQuery
     */
    public function findPrincipal(SelectQuery $query): SelectQuery
    {
        return $query
            ->where([
                $this->aliasField('principal') => true,
            ]);
    }

    /**
     * @param int $adscription_id
     * @return string
     */
    public function createValidationToken(int $adscription_id): string
    {
        $adscription = $this->find()
            ->where([$this->aliasField('id') => $adscription_id])
            ->select(['id', 'student_id', 'institution_project_id', 'tutor_id'])
            ->contain('Students', function (SelectQuery $query) {
                return $query
                    ->contain(['AppUsers'])
                    ->select(['AppUsers.dni']);
            })
            ->contain('StudentTracking', function (SelectQuery $query) {
                return $query->select(['student_adscription_id', 'date', 'hours']);
            })
            ->toArray();

        $token = substr(md5(serialize($adscription)), 0, 8);

        return $token;
    }
}
