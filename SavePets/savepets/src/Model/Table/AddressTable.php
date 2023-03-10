<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Address Model
 *
 * @property \App\Model\Table\PublicationStrayTable&\Cake\ORM\Association\BelongsToMany $PublicationStray
 *
 * @method \App\Model\Entity\Addres newEmptyEntity()
 * @method \App\Model\Entity\Addres newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Addres[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Addres get($primaryKey, $options = [])
 * @method \App\Model\Entity\Addres findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Addres patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Addres[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Addres|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Addres saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Addres[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Addres[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Addres[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Addres[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class AddressTable extends Table
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

        $this->setTable('address');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
        $this->hasOne('User', ['dependent' => true]);
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
            ->requirePresence('province', 'create',__('El campo provincia es requerido.'))
            ->notEmptyString('province',__('La provincia no puede ser vac??a.'))
            ->add('province',
            ['regex'=>[
                'rule' =>['custom','/^[\w??????-????-??\s]*$/i'],
                'message' => __('La provincia debe contener solo caracteres alfab??ticos y espacios.')
            ]])
            ->add('province',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La provincia debe tener m??nimo 3 caracteres.')
                ]])
            ->add('province',
                ['maxLength'=>[
                    'rule' =>['maxLength',30],
                    'message' => __('La provincia debe tener m??ximo 30 caracteres.')
                ]]);

        $validator
            ->requirePresence('postal_code', 'create',__('El campo c??digo postal es requerido.'))
            ->add('postal_code',
                ['regex'=>[
                    'rule' =>['custom','/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
                    'message' => __('Introduce un c??digo postal con un formato correcto.')
                ]])
            ->add('postal_code',
                ['minLength'=>[
                    'rule' =>['minLength',5],
                    'message' => __('El c??digo postal debe tener m??nimo 5 caracteres.')
                ]]);

            
        $validator
            ->requirePresence('city', 'create',__('El campo ciudad es requerido.'))
            ->notEmptyString('city',__('La ciudad no puede ser vac??o.'))
            ->add('city',
            ['regex'=>[
                'rule' =>['custom','/^[\w??????-????-??\s]*$/i'],
                'message' => __('La ciudad debe contener solo caracteres alfab??ticos y espacios.')
            ]])
            ->add('city',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La ciudad debe tener m??nimo 3 caracteres.')
                ]])
            ->add('city',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La ciudad debe tener m??ximo 100 caracteres.')
                ]]);

        $validator
                ->requirePresence('country', 'create',__('El campo pa??s es requerido.'))
                ->notEmptyString('country',__('El pa??s no puede ser vac??o.'))
                ->add('country',
                ['regex'=>[
                    'rule' =>['custom','/^[\w??????-????-??\s]*$/i'],
                    'message' => __('El pa??s debe contener solo caracteres alfab??ticos y espacios.')
                ]])
                ->add('country',
                    ['minLength'=>[
                        'rule' =>['minLength',3],
                        'message' => __('El pa??s debe tener m??nimo 3 caracteres.')
                    ]])
                ->add('country',
                    ['maxLength'=>[
                        'rule' =>['maxLength',100],
                        'message' => __('El pa??s debe tener m??ximo 100 caracteres.')
                    ]]);

        $validator
            ->requirePresence('street', 'create',__('El campo calle es requerido.'))
            ->notEmptyString('street',__('La calle no puede ser vac??a.'))
            ->add('street',
            ['regex'=>[
                'rule' =>['custom','/^[\w??????-????-??\s.??,-]*$/i'],
                'message' => __('La calle debe contener solo caracteres alfab??ticos, espacios y algunos s??mbolos [. , ?? ].')
            ]])
            ->add('street',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La calle debe tener m??nimo 3 caracteres.')
                ]])
            ->add('street',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La calle debe tener m??ximo 100 caracteres.')
                ]]);

        return $validator;
    }
}