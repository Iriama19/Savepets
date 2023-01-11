<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicationHelp Model
 *
 * @property \App\Model\Table\PublicationTable&\Cake\ORM\Association\BelongsTo $Publication
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\PublicationHelp newEmptyEntity()
 * @method \App\Model\Entity\PublicationHelp newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationHelp[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationHelp get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicationHelp findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicationHelp patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationHelp[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationHelp|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationHelp saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationHelp[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationHelp[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationHelp[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationHelp[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicationHelpTable extends Table
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

        $this->setTable('publication_help');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Publication', [
            'foreignKey' => 'publication_id',
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
            ->requirePresence('categorie', 'create', __('El campo categoría es requeria.'))
            ->notEmptyString('categorie',__('La categoría no puede ser vacía.'))
            ->add('categorie',
                ['inList'=>[
                    'rule' =>['inList',['textile','medical devices','food','leaning products','hygiene products','pet accessories','other']],
                    'message' => __('La categoría debe ser una de las existentes.')
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
        $rules->add($rules->existsIn('user_id', 'User'), ['errorField' => 'user_id']);

        return $rules;
    }
}
