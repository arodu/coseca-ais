<?php
declare(strict_types=1);

namespace App\Model\Table;

use App\Model\Entity\Lapse;
use App\Model\Field\StageField;
use App\Model\Table\Traits\BasicTableTrait;
use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Query;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Lapses Model
 *
 * @property \App\Model\Table\StudentStagesTable&\Cake\ORM\Association\HasMany $StudentStages
 *
 * @method \App\Model\Entity\Lapse newEmptyEntity()
 * @method \App\Model\Entity\Lapse newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Lapse[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Lapse get($primaryKey, $options = [])
 * @method \App\Model\Entity\Lapse findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Lapse patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Lapse[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Lapse|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lapse saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Lapse[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class LapsesTable extends Table
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

        $this->setTable('lapses');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->hasMany('StudentStages', [
            'foreignKey' => 'lapse_id',
        ]);
        $this->hasMany('LapseDates', [
            'foreignKey' => 'lapse_id',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
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
            ->boolean('active')
            ->requirePresence('active', 'create')
            ->notEmptyString('active');

        $validator
            ->date('date')
            ->requirePresence('date', 'create')
            ->notEmptyDate('date');

        return $validator;
    }

    public function afterSave(EventInterface $event, EntityInterface $entity, ArrayObject $options)
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

        $entities = $this->LapseDates->newEntities(array_map(function($item) use ($entity) {
            return [
                'lapse_id' => $entity->id,
                'title' => $item['title'] ?? $item['stage']->label(),
                'stage' => $item['stage']->value,
                'is_single_date' => $item['is_single_date'] ?? false,
            ];
        }, $defaultDates));

        $this->LapseDates->saveManyOrFail($entities);
    }

    /**
     * Undocumented function
     *
     * @param Query $query
     * @param array $options
     * @return Query
     */
    public function findCurrentLapse(Query $query, array $options): Query
    {
        return $query->find('lastElement', [
            'fieldGroup' => 'tenant_id',
            'onlyActive' => true,
        ]);
    }
}
