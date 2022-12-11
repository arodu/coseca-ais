<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Institutions Model
 *
 * @property \App\Model\Table\TenantsTable&\Cake\ORM\Association\BelongsTo $Tenants
 * @property \App\Model\Table\ProjectsTable&\Cake\ORM\Association\HasMany $Projects
 *
 * @method \App\Model\Entity\Institution newEmptyEntity()
 * @method \App\Model\Entity\Institution newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Institution[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Institution get($primaryKey, $options = [])
 * @method \App\Model\Entity\Institution findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Institution patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Institution[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Institution|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Institution saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Institution[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class InstitutionsTable extends Table
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

        $this->setTable('institutions');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Tenants', [
            'foreignKey' => 'tenant_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Projects', [
            'foreignKey' => 'institution_id',
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
            ->scalar('contact_person')
            ->maxLength('contact_person', 255)
            ->requirePresence('contact_person', 'create')
            ->notEmptyString('contact_person');

        $validator
            ->scalar('contact_phone')
            ->maxLength('contact_phone', 255)
            ->requirePresence('contact_phone', 'create')
            ->notEmptyString('contact_phone');

        $validator
            ->scalar('contact_email')
            ->maxLength('contact_email', 255)
            ->requirePresence('contact_email', 'create')
            ->notEmptyString('contact_email');

        $validator
            ->integer('tenant_id')
            ->notEmptyString('tenant_id');

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
        $rules->add($rules->existsIn('tenant_id', 'Tenants'), ['errorField' => 'tenant_id']);

        return $rules;
    }
}
