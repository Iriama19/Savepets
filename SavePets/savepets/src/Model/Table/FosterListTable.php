<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * FosterList Model
 *
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsTo $User
 * @property \App\Model\Table\UserTable&\Cake\ORM\Association\BelongsToMany $User
 *
 * @method \App\Model\Entity\FosterList newEmptyEntity()
 * @method \App\Model\Entity\FosterList newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\FosterList[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\FosterList get($primaryKey, $options = [])
 * @method \App\Model\Entity\FosterList findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\FosterList patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\FosterList[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\FosterList|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FosterList saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\FosterList[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterList[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterList[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\FosterList[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class FosterListTable extends Table
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

        $this->setTable('foster_list');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

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
        ->add('user_id', [
            'unique' => [
            'rule' => ['validateUnique'],
            'message' => 'El usuario debe ser único.' ,
             'provider' => 'table'
            ]]);

        return $validator;
    }


}
