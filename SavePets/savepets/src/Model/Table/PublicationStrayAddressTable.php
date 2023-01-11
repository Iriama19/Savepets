<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * PublicationStrayAddress Model
 *
 * @property \App\Model\Table\PublicationStrayTable&\Cake\ORM\Association\BelongsTo $PublicationStray
 * @property \App\Model\Table\AddressTable&\Cake\ORM\Association\BelongsTo $Address
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 *
 * @method \App\Model\Entity\PublicationStrayAddres newEmptyEntity()
 * @method \App\Model\Entity\PublicationStrayAddres newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres get($primaryKey, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class PublicationStrayAddressTable extends Table
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

        $this->setTable('publication_stray_address');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('PublicationStray', [
            'foreignKey' => 'publication_stray_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Address', [
            'foreignKey' => 'addres_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('User', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER',
        ]);
        $this->belongsTo('Publication', [
            'foreignKey' => 'publication_id',
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
            ->integer('publication_stray_id',__('El índice de la publicación debe ser un entero.'))
            ->notEmptyString('publication_stray_id',__('El identificador de publicación no puede ser vacío.'));

        $validator
            ->integer('addres_id',__('El índice de la dirección debe ser un entero.'))
            ->notEmptyString('addres_id',__('El identificador de dirección no puede ser vacío.'));

        $validator
            ->integer('user_id',__('El índice del usuario debe ser un entero.'))
            ->notEmptyString('user_id',__('El identificador de usuario no puede ser vacío.'));

        $validator
            ->requirePresence('publication_date', 'create', __('La fecha de publicación es requerido.'))
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
                ],
                ]);


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
        $rules->add($rules->existsIn('publication_stray_id', 'PublicationStray'), ['errorField' => 'publication_stray_id']);
        $rules->add($rules->existsIn('addres_id', 'Address'), ['errorField' => 'addres_id']);
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
