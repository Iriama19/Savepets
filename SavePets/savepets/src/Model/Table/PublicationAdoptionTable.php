<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicationAdoption Model
 *
 * @property \App\Model\Table\PublicationTable&\Cake\ORM\Association\BelongsTo $Publication
 * @property \App\Model\Table\AnimalTable&\Cake\ORM\Association\BelongsTo $Animal
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\PublicationAdoption newEmptyEntity()
 * @method \App\Model\Entity\PublicationAdoption newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationAdoption[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationAdoption get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicationAdoption findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicationAdoption patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationAdoption[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationAdoption|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationAdoption saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicationAdoptionTable extends Table
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

        $this->setTable('publication_adoption');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Publication', [
            'foreignKey' => 'publication_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Animal', [
            'foreignKey' => 'animal_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('Comment', [ 'foreignKey' => 'publication_id','bindingKey'=>'publication_id','dependent' => true
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
            ->integer('publication_id',__('El índice de la publicación debe ser un entero.'))
            ->notEmptyString('publication_id',__('El identificador de publicación no puede ser vacío.'));


        $validator
            ->integer('animal_id',__('El índice del animal debe ser un entero.'));

        $validator
            ->requirePresence('urgent', 'create',__('El campo urgente es requerido.'))
            ->notEmptyString('urgent',__('Urgente no puede ser vacía.'))
            ->add('urgent',
                ['inList'=>[
                    'rule' =>['inList',['yes','no']],
                    'message' => __('Urgente debe ser sí o no.')
                ]]);

        $validator
            ->integer('user_id',__('El índice del usuario debe ser un entero.'))
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
        $rules->add($rules->existsIn('animal_id', 'Animal'), ['errorField' => 'animal_id']);
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);

        return $rules;
    }
}
