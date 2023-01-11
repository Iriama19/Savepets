<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Event Model
 *
 * @method \App\Model\Entity\Event newEmptyEntity()
 * @method \App\Model\Entity\Event newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Event[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Event get($primaryKey, $options = [])
 * @method \App\Model\Entity\Event findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Event patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Event[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Event|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Event[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class EventTable extends Table
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

        $this->setTable('event');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Address', [
            'foreignKey' => 'addres_id',
        ]);

        $this->belongsTo('Address', [
            'foreignKey' => 'addres_id',
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
            ->requirePresence('title', 'create',__('El campo título es requerido.'))
            ->add('title',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,-]*$/i'],
                'message' => __('El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
            ]])
            ->notEmptyString('title',__('El título no puede ser vacío.'))
            ->add('title',
            ['minLength'=>[
                'rule' =>['minLength',3],
                'message' => __('El título debe tener mínimo 3 caracteres.')
            ]])
            ->add('title',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El título debe tener máximo 100 caracteres.')
                ]]);

        $validator
        ->allowEmptyString('message', __('El mensaje puede ser vacío'))
        ->add('message',
        ['regex'=>[
            'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,-]*$/i'],
            'message' => __('El mensaje debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
        ]])
        ->add('message',
            ['maxLength'=>[
                'rule' =>['maxLength',300],
                'message' => __('El mensaje debe tener máximo 300 caracteres.')
            ]]);


        $validator
            ->requirePresence('start_date', 'create',__('El campo fecha de inicio es requerido.'))
            ->notEmptyDateTime('start_date', __('La fecha de inicio no puede ser vacía.'))
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
                ]
                ]);

        $validator
            ->requirePresence('end_date', 'create', __('El campo fecha de fin es requerido.'))
            ->notEmptyDateTime('end_date', __('La fecha de fin no puede ser vacía.'))
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
                ]
                ]);

        $validator
            ->integer('user_id', __('El id del usuario debe ser un número entero.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));

        $validator
            ->integer('addres_id', __('El id de la dirección debe ser un número entero.'))
            ->notEmptyString('addres_id',__('El identificador de dirección no puede ser vacío.'));

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
        $rules->add($rules->existsIn('addres_id', 'Address'), ['errorField' => 'addres_id']);

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
