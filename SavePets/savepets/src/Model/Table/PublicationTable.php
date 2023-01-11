<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Publication Model
 *
 * @method \App\Model\Entity\Publication newEmptyEntity()
 * @method \App\Model\Entity\Publication newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Publication[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Publication get($primaryKey, $options = [])
 * @method \App\Model\Entity\Publication findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Publication patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Publication[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Publication|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Publication saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicationTable extends Table
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

        $this->setTable('publication');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        $this->hasOne('PublicationStray', ['dependent' => true]);
        $this->hasOne('PublicationAdoption', ['dependent' => true]);
        $this->hasOne('PublicationHelp', ['dependent' => true]);

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
            ->requirePresence('publication_date', 'create', __('El campo fecha de publicación es requerido.'))
            ->notEmptyDateTime('publication_date',__('La fecha no puede ser vacía.'))
            ->add('publication_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha debe ser entre 2022 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('publication_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha introducida debe seguir un formato de fecha y hora correcto.',
                ]
                ]);

        $validator
            ->scalar('title',__('El título debe ser un escalar.'))
            ->requirePresence('title', 'create', __('El campo título es requerido.'))
            ->notEmptyString('title',__('El título no puede ser vacío.'))
            ->add('title',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,\?\¿\¡\!-]*$/i'],
                    'message' => __('El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
                ]])
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
            ->scalar('message',__('El mensaje debe ser un escalar.'))
            ->requirePresence('message', 'create', __('El campo mensaje es requerido.'))
            ->notEmptyString('message',__('El mensaje no puede ser vacío.'))
            ->add('message',
            ['regex'=>[
                'rule' =>['custom','/^[\wñçÁ-Úá-ú\s.º,-]*$/i'],
                'message' => __('El mensaje debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].')
            ]])
            ->add('message',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('El mensaje debe tener mínimo 3 caracteres.')
                ]])
            ->add('message',
                ['maxLength'=>[
                    'rule' =>['maxLength',700],
                    'message' => __('El mensaje debe tener máximo 700 caracteres.')
                ]]);

        return $validator;
    }
    public function validoDateBetween($date){
        if('2022-01-01 00:00:00' > $date || '2050-01-01 00:00:00' < $date){
            return false;
        }else{
            return true;
        }
    }
}
