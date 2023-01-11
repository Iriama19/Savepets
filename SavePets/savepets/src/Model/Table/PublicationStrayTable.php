<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicationStray Model
 *
 * @property \App\Model\Table\AddressTable&\Cake\ORM\Association\BelongsToMany $Address
 *
 * @method \App\Model\Entity\PublicationStray newEmptyEntity()
 * @method \App\Model\Entity\PublicationStray newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStray[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStray get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicationStray findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicationStray patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStray[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStray|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationStray saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicationStrayTable extends Table
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

        $this->setTable('publication_stray');
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
        $this->belongsToMany('Address', [
            'foreignKey' => 'publication_stray_id',
            'targetForeignKey' => 'addres_id',
            'joinTable' => 'publication_stray_address',
        ]);
        $this->hasMany('Comment', [ 'foreignKey' => 'publication_id','bindingKey'=>'publication_id','dependent' => true]);

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
            ->allowEmptyFile('image',__('La imagen puede ser vacía.'));
        //     ->add( 'image', [
        //     'mimeType' => [
        //         'rule' => [ 'mimeType', [ 'image/jpg', 'image/png', 'image/jpeg' ] ],
        //         'message' => 'Por favor, sube unicamente ficheros png, jpg y jpeg.',
        //     ],
        //     'fileSize' => [
        //         'rule' => [ 'fileSize', '<=', '1MB' ],
        //         'message' => 'El tamaño de la imagen debe ser menor de 1MB.',
        //     ],
        // ] );

        $validator
            ->requirePresence('urgent', 'create',__('El campo urgente es requerido.'))
            ->notEmptyString('urgent',__('Urgente no puede ser vacío.'))
            ->add('urgent',
                ['inList'=>[
                    'rule' =>['inList',['yes','no']],
                    'message' => __('Urgente debe ser sí o no.')
                ]]);

        $validator
            ->integer('user_id', __('El índice del usuario debe ser un entero.'))
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
