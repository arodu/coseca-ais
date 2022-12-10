<?php

declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Field\StageField;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * LapseDates Model
 *
 * @property \App\Model\Table\LapsesTable&\Cake\ORM\Association\BelongsTo $Lapses
 *
 * @method \App\Model\Entity\LapseDate newEmptyEntity()
 * @method \App\Model\Entity\LapseDate newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\LapseDate[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\LapseDate get($primaryKey, $options = [])
 * @method \App\Model\Entity\LapseDate findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\LapseDate patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\LapseDate[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\LapseDate|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LapseDate saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\LapseDate[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LapseDate[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\LapseDate[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\LapseDate[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LapseDatesTable extends Table
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

        $this->setTable('lapse_dates');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

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
            ->integer('lapse_id')
            ->notEmptyString('lapse_id');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->requirePresence('title', 'create')
            ->notEmptyString('title');

        $validator
            ->scalar('stage')
            ->maxLength('stage', 255)
            ->requirePresence('stage', 'create')
            ->notEmptyString('stage');

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
        $rules->add($rules->existsIn('lapse_id', 'Lapses'), ['errorField' => 'lapse_id']);

        return $rules;
    }

    public function beforeSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
    {
        if ($entity->is_single_date) {
            $entity->end_date = null;
        }
    }

    /**
     * @param integer $lapse_id
     * @return iterable
     */
    public function saveDefaultDates(int $lapse_id): iterable
    {
        $defaultDates = [
            [
                'stage' => StageField::REGISTER,
                'title' => null,
                'is_single_date' => false,
            ],
            [
                'stage' => StageField::COURSE,
                'title' => null,
                'is_single_date' => true,
            ],
            [
                'stage' => StageField::TRACKING,
                'title' => null,
                'is_single_date' => false,
            ],
            [
                'stage' => StageField::ENDING,
                'title' => __('Exporeria'),
                'is_single_date' => true,
            ],
        ];

        $entities = $this->newEntities(array_map(function ($item) use ($lapse_id) {
            return [
                'lapse_id' => $lapse_id,
                'title' => $item['title'] ?? $item['stage']->label(),
                'stage' => $item['stage']->value,
                'is_single_date' => $item['is_single_date'] ?? false,
            ];
        }, $defaultDates));

        return $this->saveManyOrFail($entities);
    }
}
