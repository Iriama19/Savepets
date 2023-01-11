<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Comment Model
 *
 * @method \App\Model\Entity\Comment newEmptyEntity()
 * @method \App\Model\Entity\Comment newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\Comment[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Comment get($primaryKey, $options = [])
 * @method \App\Model\Entity\Comment findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\Comment patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Comment[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\Comment|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Comment saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class CommentTable extends Table
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

        $this->setTable('comment');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Publication', [
            'foreignKey' => 'publication_id',
            'joinType' => 'INNER',
        ]);

        $this->belongsTo('PublicationHelp', [
            'foreignKey' => 'publication_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PublicationAdoption', [
            'foreignKey' => 'publication_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('PublicationStray', [
            'foreignKey' => 'publication_id',
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
            ->requirePresence('comment_date', 'create', __('El campo fecha de comentario es requerido.'))
            ->notEmptyDateTime('comment_date',__('La fecha no puede ser vacía.'))
            ->add('comment_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'La fecha de comentario debe ser entre 2022 y 2050.'
                , 'provider' => 'table'
                ]])
            ->add('comment_date', [
                'dateTime' => [
                'rule' => ['dateTime'],
                'message' => 'La fecha introducida debe seguir un formato de fecha y hora correcto.',
                ]]);

        $validator
            ->requirePresence('message', 'create', __('El campo mensaje es requerido.'))
            ->notEmptyString('message', __('El mensaje no puede ser vacío.'))
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
                    'rule' =>['maxLength',300],
                    'message' => __('El mensaje debe tener máximo 300 caracteres.')
                ]]);

        $validator
            ->integer('publication_id',  __('El índice de publicación debe ser un entero.'))
            ->notEmptyString('publication_id',__('El identificador de publicación no puede ser vacío.'));

        $validator
            ->integer('user_id',  __('El índice del usuario debe ser un entero.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));
            
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
        $rules->add($rules->existsIn('publication_id', 'Publication'), ['errorField' => 'publication_id']);
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);

        return $rules;
    }


    public function validoDateBetween($date){
        if('2022-01-01 00:00:00' > $date || '2050-01-01 00:00:00' < $date){
            return false;
        }else{
            return true;
        }
    }
}
