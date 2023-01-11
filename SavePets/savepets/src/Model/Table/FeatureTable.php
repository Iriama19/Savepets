<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Feature Model
 *
 * @method \App\Model\Entity\Feature newEmptyEntity()
 * @method \App\Model\Entity\Feature newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Feature[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Feature get($primaryKey, $options = [])
 * @method \App\Model\Entity\Feature findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Feature patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Feature[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Feature|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feature saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FeatureTable extends Table
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

        $this->setTable('feature');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsToMany('Profile', [
            'foreignKey' => 'feature_id',
            'targetForeignKey' => 'profile_id',
            'joinTable' => 'feature_profile',
        ]);
        $this->belongsToMany('User', [
            'foreignKey' => 'feature_id',
            'targetForeignKey' => 'user_id',
            'joinTable' => 'feature_user',
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
            ->scalar('key_feature', __('La clave de la característica debe ser un escalar.'))
            ->requirePresence('key_feature', 'create', __('El campo clave es requerido.'))
            ->notEmptyString('key_feature',__('La clave no puede ser vacía.'))

            ->add('key_feature',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La clave debe tener mínimo 3 caracteres.')
                ]])
            ->add('key_feature', [
                    'unique' => [
                    'rule' => ['validateUnique'],
                    'message' => 'La clave debe ser única.'
                    , 'provider' => 'table'
                    ]
                    ])
            ->add('key_feature',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La clave debe tener máximo 100 caracteres.')
                ]]);

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
        $rules->add($rules->isUnique(['key_feature']), ['errorField' => 'key_feature']);

        return $rules;
    }
}
