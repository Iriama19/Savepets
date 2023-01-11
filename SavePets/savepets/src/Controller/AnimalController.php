<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Animal Controller
 *
 * @property \App\Model\Table\AnimalTable $Animal
 * @method \App\Model\Entity\Animal[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnimalController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index', 'view']);
        
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($recomendacion=null)
    {
        $keyEspecie = $this->request->getQuery('keyEspecie');
        $keyRaza = $this->request->getQuery('keyRaza');
        $keySexo = $this->request->getQuery('keySexo');
        if($recomendacion){
            $salida = shell_exec('python3 recomendar.py '.$recomendacion);
            if($salida!=NULL){
                $resultado = explode ( ',', $salida);
                $animales = $this->Animal->find('all', ['limit' => 200])->where(['or'=>[['age'=>intval($resultado[0])],['age'=>intval($resultado[1])],['age'=>intval($resultado[2])],['race like'=>$resultado[3]],['race like'=>$resultado[4]],['race like'=>$resultado[5]],['specie'=>$resultado[6]],['specie'=>$resultado[7]],['specie'=>$resultado[8]]]]);
    
            }else{
                $animales = $this->Animal;
            }
        }else{

            if($keyEspecie||$keyRaza||$keySexo){
                $animales = $this->Animal->find('all', ['limit' => 200])->where(['race like'=>'%'.$keyRaza.'%','sex like'=>'%'.$keySexo.'%','specie like'=>'%'.$keyEspecie.'%']);
            }else{
                $animales = $this->Animal;
            }
        }
        $animal = $this->paginate($animales,['contain'=>['AnimalShelter'],'order' => ['id'=>'desc']]);
        $this->set(compact('animal'));
    }

    /**
     * View method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $animal = $this->Animal->get($id, [
            'contain' => ['AnimalShelter'],
        ]);
   
        $allUsers = $this->getTableLocator()->get('User');//Conecto con users
        $id_user=$animal['animal_shelter']['user_id'];
        $currentUser=$allUsers->find()->where(['id'=>$id_user])->select('name')->first();
        $currentUserIDs=$allUsers->find()->where(['id'=>$id_user])->select('id')->first();

        $currentUserName=$currentUser['name'];
        $currentUserID=$currentUserIDs['id'];
        $this->set(compact('animal','currentUserName','currentUserID'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $animal = $this->Animal->newEmptyEntity();
        if ($this->request->is('post')) {
            $animal = $this->Animal->patchEntity($animal, $this->request->getData());
             if(!$animal->getErrors){

                $image = $this->request->getData('image_file');
                $name=null;
                if($image !=NULL){
                    $name  = $image->getClientFilename();
                }

                if( !is_dir(WWW_ROOT.'img'.DS.'animal-img') ){
                    mkdir(WWW_ROOT.'img'.DS.'animal-img',0775);
                }
                if($name){
                    $targetPath = WWW_ROOT.'img'.DS.'animal-img'.DS.$name;

                    $image->moveTo($targetPath);
                    $animal->image = 'animal-img/'.$name;

                }
        
                if ($this->Animal->save($animal)) {
                    $this->Flash->success(__('El animal se ha añadido.'));
                    return $this->redirect(['action' => 'index']);
                }else{
                    $this->Flash->error(__('El animal no se ha podido añadir, por favor intentalo de nuevo'));
                }

            }
            $this->Flash->error(__('El animal no se ha podido añadir, por favor intentalo de nuevo'));
        }
        $allUsers = $this->getTableLocator()->get('User');

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('animal','user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {           
        $animal = $this->Animal->get($id, [
            'contain' => ['AnimalShelter'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $animal = $this->Animal->patchEntity($animal, $this->request->getData());
            if (!$animal->getErrors) {

                $image = $this->request->getData('change_image');
                $name=null;

                if($image !=NULL){
                    $name  = $image->getClientFilename();

                }
                if (!is_dir(WWW_ROOT . 'img' . DS . 'animal-img')){
                    mkdir(WWW_ROOT . 'img' . DS . 'animal-img', 0775);
                }
                if($name){
                    $targetPath = WWW_ROOT . 'img' . DS . 'animal-img' . DS . $name;

                    $imgpath = WWW_ROOT . 'img' . DS . $animal->image;
                    if (file_exists($imgpath)&&!preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/animal-img\/$/',$imgpath)) {
                        unlink($imgpath);
                    }              
                    $image->moveTo($targetPath);
      
                   $animal->image = 'animal-img/' . $name;
                }
        
            
                if ($this->Animal->save($animal)) {
                    $this->Flash->success(__('El animal se ha editado correctamente.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
                $this->Flash->error(__('El animal no se ha podido editar, por favor intentalo de nuevo.'));
            }

        $allUser = $this->getTableLocator()->get('User');
        $user_id_animalShelter=$animal->animal_shelter->user_id;
        $usercomplete=$allUser->find()->where(['id'=>$user_id_animalShelter])->select('name')->first();
        $userName=$usercomplete['name'];


        $allUsers = $this->getTableLocator()->get('User');

        $user = $allUsers->find('list', ['limit' => 200])->all();
        $this->set(compact('animal','userName','user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Animal id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $animal = $this->Animal->get($id);
        $imgpath = WWW_ROOT.'img'.DS.$animal->image;

        if ($this->Animal->delete($animal)) {
            if(file_exists($imgpath) ){
                $imageAnimal=$animal->image;
                if(!empty($imageAnimal)&& !preg_match('/^animal-img\/$/',$imageAnimal)){
                    unlink($imgpath);
                }
            }
            $this->Flash->success(__('El animal se ha eliminado.'));
        } else {
            $this->Flash->error(__('El animal no se ha podido eliminar, por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
