<?php
declare(strict_types=1);

namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * User Model
 *
 * @property \App\Model\Table\FeatureTable&\Cake\ORM\Association\BelongsToMany $Feature
 * @property \App\Model\Table\FosterListTable&\Cake\ORM\Association\BelongsToMany $FosterList
 * @property \App\Model\Table\ProfileTable&\Cake\ORM\Association\BelongsToMany $Profile
 *
 * @method \App\Model\Entity\User newEmptyEntity()
 * @method \App\Model\Entity\User newEntity(array $data, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, ?callable $callback = null, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities(iterable $entities, array $data, array $options = [])
 * @method \App\Model\Entity\User|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false saveMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface saveManyOrFail(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface|false deleteMany(iterable $entities, $options = [])
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface deleteManyOrFail(iterable $entities, $options = [])
 */
class UserTable extends Table
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

        $this->setTable('user');
        $this->setDisplayField('username');
        $this->setPrimaryKey('id');
        $this->belongsTo('Address', [
            'foreignKey' => 'addres_id',
            'joinType' => 'INNER',
        ]);
        $this->hasMany('FeatureUser', [
            'dependent' => true
        ]);
        // $this->belongsToMany('FosterList', [
        //     'foreignKey' => 'user_id',
        //     'targetForeignKey' => 'foster_list_id',
        //     'joinTable' => 'foster_list_user',
        // ]);
        // $this->belongsToMany('Profile', [
        //     'foreignKey' => 'user_id',
        //     'targetForeignKey' => 'profile_id',
        //     'joinTable' => 'profile_user',
        // ]);
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
            ->requirePresence('DNI_CIF', 'create', __('El campo DNI/CIF/NIE es requerido.'))
            ->notEmptyString('DNI_CIF',__('El DNI/NIE/CIF no puede ser vacío.'))

            ->add('DNI_CIF',
                ['regex'=>[
                    'rule' =>['custom','/^([ABCDEFGHJKLMNPQRSUVW])(\d{7})([0-9A-J])$|^(\d{8})([A-Z])$|^[XYZ]\d{7,8}[A-Za-z]$/'],
                    'message' => __('Introduce un DNI/NIE/CIF en el formato correcto.')
                ]])
            ->add('DNI_CIF', [
                'custom' => [
                'rule' => [$this,'validoDNI'],
                'message' => 'El DNI/NIE/CIF debe ser válido.'
                , 'provider' => 'table'
                ]])
            ->add('DNI_CIF',
                ['minLength'=>[
                    'rule' =>['minLength',8],
                    'message' => __('El DNI/NIE/CIF debe tener mínimo 8 caracteres.')
                ]])
            ->add('DNI_CIF', [
                    'unique' => [
                    'rule' => ['validateUnique'],
                    'message' => 'El DNI/NIE/CIF debe ser único.'
                    , 'provider' => 'table'
                    ]
                    ])
            ->add('DNI_CIF',
                ['maxLength'=>[
                    'rule' =>['maxLength',9],
                    'message' => __('El DNI/NIE/CIF debe tener máximo 9 caracteres.')
                ]]);

        $validator
            ->requirePresence('name', 'create', __('El campo nombre es requerido.'))
            ->notEmptyString('name', __('El nombre no puede ser vacío.'))
            ->add('name',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                    'message' => __('Introduce un nombre con caracteres alfabéticos y espacios.')
                ]])
            ->add('name',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('El nombre debe tener mínimo 3 caracteres.')
                ]])
            ->add('name',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El nombre debe tener máximo 100 caracteres.')
                ]]);

        $validator
            ->allowEmptyString('lastname', __('El apellido puede ser vacío.'))
            ->add('lastname',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s]*$/i'],
                    'message' => __('Introduce un apellido con caracteres alfabéticos y espacios.')
                ]])
            ->add('lastname',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('El apellido debe tener máximo 100 caracteres.')
                ]]);

        $validator
            ->requirePresence('username', 'create', __('El campo alias de usuario es requerido.'))
            ->notEmptyString('username',__('El alias de usuario no puede ser vacío.'))
            ->add('username',
                ['regex'=>[
                    'rule' =>['custom','/^[\wñçÁ-Úá-ú\s0-9]*$/i'],
                    'message' => __('Introduce un alias de usuario alfanumérico.')
                ]])
            ->add('username',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('El alias de usuario debe tener mínimo 3 caracteres.')
                ]])
            ->add('username',
                ['maxLength'=>[
                    'rule' =>['maxLength',30],
                    'message' => __('El alias de usuario debe tener máximo 30 caracteres.')
                ]])
            ->add('username', [
                    'unique' => [
                    'rule' => ['validateUnique'],
                    'message' => 'El alias de usuario debe ser único.' ,
                     'provider' => 'table'
                    ]]);

        $validator
            ->requirePresence('password', 'create', __('El campo contraseña es requerido.'))
            ->notEmptyString('password',_('La contraseña no puede ser vacía.'))
            ->add('password',
                ['minLength'=>[
                    'rule' =>['minLength',3],
                    'message' => __('La contraseña debe tener mínimo 3 caracteres.')
                ]])
            ->add('password',
                ['maxLength'=>[
                    'rule' =>['maxLength',100],
                    'message' => __('La contraseña debe tener máximo 100 caracteres.')
                ]]);

        $validator
            ->requirePresence('email', 'create', __('El campo email es requerido.'))
            ->notEmptyString('email',__('El email no puede ser vacío.'))
            ->add('email', [
                    'unique' => [
                    'rule' => ['validateUnique'],
                    'message' => 'El email debe ser único.'
                    , 'provider' => 'table'
                    ]
                    ])
            ->add('email',
                ['email'=>[
                    'rule' =>['email'],
                    'message' => __('Debe seguir un formato de email.')
                ]]);

        $validator
            ->scalar('phone',__('Introduce un formato de teléfono correcto.'))
            ->requirePresence('phone', 'create', __('El campo teléfono es requerido.'))
            ->notEmptyString('phone',__('El teléfono no puede ser vacío.'))
            ->add('phone',
                ['regex'=>[
                    'rule' =>['custom','/^((\+\d{2}|00\d{2}|\d{2})?\s?[0-9]{9})$/'],
                    'message' => __('Introduce un formato de teléfono correcto.')
                ]])
            ->add('phone',
                ['minLength'=>[
                    'rule' =>['minLength',9],
                    'message' => __('El teléfono debe tener mínimo 9 caracteres.')
                ]])

            ->add('phone', [
                'unique' => [
                'rule' => ['validateUnique'],
                'message' => 'El teléfono debe ser único.',
                 'provider' => 'table'
                ]])
            ->add('phone',
                ['maxLength'=>[
                    'rule' =>['maxLength',15],
                    'message' => __('El teléfono debe tener máximo 15 caracteres.')
                ]]);

        $validator
            ->requirePresence('role', 'create', __('El campo rol es requerido.'))
            ->notEmptyString('role',__('El rol no puede ser vacío.'))
            ->add('role',
                ['inList'=>[
                    'rule' =>['inList',['admin','shelter','standar']],
                    'message' => __('El rol de usuario debe ser estándar, protectora o administrador.')
                ]]);

        $validator
            ->requirePresence('birth_date', 'create',__('El campo fecha de nacimiento es requerido.'))
            ->notEmptyDate('birth_date', __('La fecha de nacimiento no puede ser vacía.'))
            ->add('birth_date', [
                'custom' => [
                'rule' => [$this,'validoDateBetween'],
                'message' => 'El usuario debe ser mayor de edad.'
                , 'provider' => 'table'
                ]])
            ->add('birth_date', [
                'date' => [
                'rule' => ['date'],
                'message' => 'La fecha de nacimiento introducida debe seguir un formato de fecha.',
                ]
                ]);
    
        $validator
            ->integer('addres_id','El identificador de la dirección es un número.')
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
        $rules->add($rules->isUnique(['username']), ['errorField' => 'username']);
        $rules->add($rules->isUnique(['DNI_CIF']), ['errorField' => 'DNI_CIF']);
        $rules->add($rules->isUnique(['email']), ['errorField' => 'email']);
        $rules->add($rules->isUnique(['phone']), ['errorField' => 'phone']);

        return $rules;
    }

    public function validoDateBetween($date){
        $now = date("Y-m-d");
        // Calculate the time difference between the two dates
        $diff = date_diff(date_create($date), date_create($now));
        $edad=intval($diff->format('%y'));
        if($edad<18){
            return false;
        }else{
            return true;
        }
    }
    /**
     * Añadida por Iria Martínez Álvarez
     * Comprobar DNI/CIF/NIE
     */

    public function validoDNI($DNI_CIF){
        $DNI_CIF = strtoupper($DNI_CIF);
  
        for ($i = 0; $i < 9; $i ++){
              $num[$i] = substr($DNI_CIF, $i, 1);
        }
        //si no tiene un formato valido devuelve error
        if (!preg_match('/((^[A-Z]{1}[0-9]{7}[A-Z0-9]{1}$|^[T]{1}[A-Z0-9]{8}$)|^[0-9]{8}[A-Z]{1}$)/', $DNI_CIF)){
              return true;
        }
        //comprobacion de NIFs estandar
        
        if (preg_match('/(^[0-9]{8}[A-Z]{1}$)/', $DNI_CIF)){
         if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr($DNI_CIF, 0, 8) % 23, 1)){
          return true;
         }else {
          return false;
         }
        }
        //algoritmo para comprobacion de codigos tipo CIF
        $cif_codes = 'JABCDEFGHI';

        $sum = (string) $this->getCifSum ($DNI_CIF);
        $n = (10 - substr ($sum, -1)) % 10;

        if (preg_match ('/^[ABCDEFGHJNPQRSUVW]{1}/', $DNI_CIF)) {
            if (in_array ($DNI_CIF[0], array ('A', 'B', 'E', 'H'))) {
            // Numerico
                if ($DNI_CIF[8] == $n){
                    return true;
                }else{
                    return false;
                }
            } elseif (in_array ($DNI_CIF[0], array ('K', 'P', 'Q', 'S'))) {
            // Letras
                if ($DNI_CIF[8] == $cif_codes[$n]){
                    return true;
                }else{
                    return false;
                }
            } else {
            // Alfanumérico
                if (is_numeric ($DNI_CIF[8])) {
                    return ($DNI_CIF[8] == $n);
                } else {
                    if($DNI_CIF[8] == $cif_codes[$n]){
                        return true;
                    }else{
                        return false;
                    }
                }
            }
        }

        //comprobacion de NIEs
        //T
        if (preg_match('/^[T]{1}/', $DNI_CIF)){
         if ($num[8] == preg_match('/^[T]{1}[A-Z0-9]{8}$/', $DNI_CIF)){
          return true;
         }else{
          return false;
         }
        }
        //XYZ
        if (preg_match('/^[XYZ]{1}/', $DNI_CIF)){
         if ($num[8] == substr('TRWAGMYFPDXBNJZSQVHLCKE', substr(str_replace(array('X','Y','Z'),
       
             array('0','1','2'), $DNI_CIF), 0, 8) % 23, 1)){
          return true;
         }else{
          return false;
         }
        }
        //si todavia no se ha verificado devuelve error
        return false;
       } 

       function getCifSum($cif) {
        $sum = $cif[2] + $cif[4] + $cif[6];
  
        for ($i = 1; $i<8; $i += 2) {
          $tmp = (string) (2 * $cif[$i]);
  
          $tmp = $tmp[0] + ((strlen ($tmp) == 2) ?  $tmp[1] : 0);
  
          $sum += $tmp;
        }
  
        return $sum;
      }
       
}