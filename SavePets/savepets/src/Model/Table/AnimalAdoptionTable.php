<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AnimalAdoption Model
 *
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 * @property \App\Model\Table\AnimalTable&\Cake\ORM\Association\BelongsTo $Animal
 *
 * @method \App\Model\Entity\AnimalAdoption newEmptyEntity()
 * @method \App\Model\Entity\AnimalAdoption newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\AnimalAdoption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AnimalAdoption get($primaryKey, $options = [])
 * @method \App\Model\Entity\AnimalAdoption findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\AnimalAdoption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AnimalAdoption[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\AnimalAdoption|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnimalAdoption saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AnimalAdoption[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AnimalAdoption[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\AnimalAdoption[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\AnimalAdoption[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AnimalAdoptionTable extends Table
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

        $this->setTable('animal_adoption');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Animal', [
            'foreignKey' => 'animal_id',
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
            ->requirePresence('start_date', 'create',__('El campo fecha de inicio es requerido.'))
            ->notEmptyDateTime('start_date',__('El campo de la fecha de inicio no puede estar vacío.'))
            ->add('start_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha de inicio debe ser entre 1990 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('start_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha de inicio introducida debe seguir un formato de fecha y hora correcto.',
                ],
                ]);

        $validator
            ->allowEmptyDateTime('end_date',__('El valor introducido en la fecha de fin puede ser vacío.'))
            ->add('end_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha de fin debe ser entre 1990 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('end_date', [
                'endlatter' => [
                'rule' => function ($value, $context){
                    if(array_key_exists('end_date',$context["data"])&& array_key_exists('start_date',$context["data"])){
                        if($context["data"]['end_date'] !=NULL && $context["data"]['start_date'] !=NULL){
                            return $context["data"]['start_date']<= $context["data"]['end_date'];
                        }else{
                            return true;
                        }
                    }
                },
                'message' => 'La fecha de fin tiene que ser más tarde que la de inicio.'
                ]])
            ->add('end_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha de fin introducida debe seguir un formato de fecha y hora correcto.',
                ],
            ]);

        $validator
            ->integer('user_id',__('El identificador del usuario es un número.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));

        $validator
            ->integer('animal_id','El identificador del animal es un número.')
            ->notEmptyString('animal_id',__('El identificador de animal no puede ser vacío.'));

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
        $rules->add($rules->existsIn('animal_id', 'Animal'), ['errorField' => 'animal_id']);

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
