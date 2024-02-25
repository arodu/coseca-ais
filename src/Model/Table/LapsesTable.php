<?php
declare(strict_types=1);

namespace App\Model\Table;

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

        $this->addBehavior('LastElement', [
            'fieldGroup' => 'tenant_id',
            'subQueryConditions' => [
                $this->aliasField('active') => true,
            ],
        ]);
        $this->addBehavior('FilterTenant');

        $this->hasMany('LapseDates', [
            'foreignKey' => 'lapse_id',
        ]);
        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'finder' => 'withPrograms',
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

        return $validator;
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
            $this->LapseDates->saveDefaultDates($entity->id);
        }
    }

    /**
     * @param \Cake\ORM\Query $query query
     * @param array $options options
     * @return \Cake\ORM\Query
     */
    public function findCurrentLapse(Query $query, array $options): Query
    {
        if (empty($options['tenant_id'])) {
            throw new \InvalidArgumentException('Missing tenant_id');
        }

        return $query
            ->find('lastElement')
            ->where([
                $this->aliasField('tenant_id') => $options['tenant_id'],
                $this->aliasField('active') => true,
            ]);
    }
}
