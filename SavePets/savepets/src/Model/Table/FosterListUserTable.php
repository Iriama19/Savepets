<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FosterListUser Model
 *
 * @method \App\Model\Entity\FosterListUser newEmptyEntity()
 * @method \App\Model\Entity\FosterListUser newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FosterListUser[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FosterListUser get($primaryKey, $options = [])
 * @method \App\Model\Entity\FosterListUser findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FosterListUser patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FosterListUser[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FosterListUser|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FosterListUser saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FosterListUser[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterListUser[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterListUser[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterListUser[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FosterListUserTable extends Table
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

        $this->setTable('foster_list_user');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('FosterList', [
            'foreignKey' => 'foster_list_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
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
            ->integer('foster_list_id',__('El índice de la lista de adopción debe ser un entero.'));

            $validator
            ->integer('user_id',__('El índice del usuario debe ser un entero.'));


        $validator
            ->requirePresence('specie', 'create', __('El campo especie es requerido.'))
            ->notEmptyString('specie', __('La especie no puede ser vacía.'))
            ->add('specie',
                ['inList'=>[
                    'rule' =>['inList',['cat','dog','bunny','hamster','snake','turtles','other','indifferent']],
                    'message' => __('La especie debe ser una de las opciones.')
                ]]);
        $validator
            ->allowEmptyDateTime('foster_date', __('La fecha de la lista de adopción puede ser vacía.'))
            ->add('foster_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha de la lista de acogida debe ser entre 1990 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('foster_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha introducida debe seguir un formato de fecha y hora correcto.',
                ]
                ]);
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
        $rules->add($rules->existsIn('foster_list_id', 'FosterList'), ['errorField' => 'foster_list_id']);
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);

        return $rules;
    }

    public function validoDateBetween($date){
        if('1990-01-01 00:00:00' > $date || '2050-01-01 00:00:00' < $date){
            return false;
        }else{
            return true;
        }
    }
}
