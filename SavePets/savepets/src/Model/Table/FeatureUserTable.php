<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FeatureUser Model
 *
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 * @property \App\Model\Table\FeatureTable&\Cake\ORM\Association\BelongsTo $Feature
 *
 * @method \App\Model\Entity\FeatureUser newEmptyEntity()
 * @method \App\Model\Entity\FeatureUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FeatureUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FeatureUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\FeatureUser findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FeatureUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FeatureUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FeatureUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeatureUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FeatureUser[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FeatureUser[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FeatureUser[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FeatureUser[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FeatureUserTable extends Table
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

        $this->setTable('feature_user');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Feature', [
            'foreignKey' => 'feature_id',
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
            ->integer('user_id',  __('El índice del usuario debe ser un entero.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));

        $validator
            ->integer('feature_id',  __('El índice de la característica debe ser un entero.'))
            ->notEmptyString('user_id',__('El identificador de característica no puede ser vacío.'));

        $validator
            ->scalar('value', __('El valor debe ser un escalar.'))
            ->allowEmptyString('value')
            ->add('value',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El valor debe tener máximo 100 caracteres.')
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
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);
        $rules->add($rules->existsIn('feature_id', 'Feature'), ['errorField' => 'feature_id']);

        return $rules;
    }
}
