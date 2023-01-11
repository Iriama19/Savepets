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
            ->notEmptyString('province',__('La provincia no puede ser vacía.'))
            ->add('province',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                'message' => __('La provincia debe contener solo caracteres alfabéticos y espacios.')
            ]])
            ->add('province',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La provincia debe tener mínimo 3 caracteres.')
                ]])
            ->add('province',
                ['maxLength'=>[
                    'rule' =>['maxLength',30],
                    'message' => __('La provincia debe tener máximo 30 caracteres.')
                ]]);

        $validator
            ->requirePresence('postal_code', 'create',__('El campo código postal es requerido.'))
            ->add('postal_code',
                ['regex'=>[
                    'rule' =>['custom','/^(?:0[1-9]|[1-4]\d|5[0-2])\d{3}$/'],
                    'message' => __('Introduce un código postal con un formato correcto.')
                ]])
            ->add('postal_code',
                ['minLength'=>[
                    'rule' =>['minLength',5],
                    'message' => __('El código postal debe tener mínimo 5 caracteres.')
                ]]);

            
        $validator
            ->requirePresence('city', 'create',__('El campo ciudad es requerido.'))
            ->notEmptyString('city',__('La ciudad no puede ser vacío.'))
            ->add('city',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                'message' => __('La ciudad debe contener solo caracteres alfabéticos y espacios.')
            ]])
            ->add('city',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La ciudad debe tener mínimo 3 caracteres.')
                ]])
            ->add('city',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La ciudad debe tener máximo 100 caracteres.')
                ]]);

        $validator
                ->requirePresence('country', 'create',__('El campo país es requerido.'))
                ->notEmptyString('country',__('El país no puede ser vacío.'))
                ->add('country',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                    'message' => __('El país debe contener solo caracteres alfabéticos y espacios.')
                ]])
                ->add('country',
                    ['minLength'=>[
                        'rule' =>['minLength',3],
                        'message' => __('El país debe tener mínimo 3 caracteres.')
                    ]])
                ->add('country',
                    ['maxLength'=>[
                        'rule' =>['maxLength',100],
                        'message' => __('El país debe tener máximo 100 caracteres.')
                    ]]);

        $validator
            ->requirePresence('street', 'create',__('El campo calle es requerido.'))
            ->notEmptyString('street',__('La calle no puede ser vacía.'))
            ->add('street',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,-]*$/i'],
                'message' => __('La calle debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
            ]])
            ->add('street',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La calle debe tener mínimo 3 caracteres.')
                ]])
            ->add('street',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La calle debe tener máximo 100 caracteres.')
                ]]);

        return $validator;
    }
}