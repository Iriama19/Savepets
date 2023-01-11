<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AnimalAdoption Controller
 *
 * @property \App\Model\Table\AnimalAdoptionTable $AnimalAdoption
 * @method \App\Model\Entity\AnimalAdoption[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnimalAdoptionController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        if($this->Authentication->getIdentity()){

            $keyAnimal = $this->request->getQuery('keyAnimal');
            $keyUsuario = $this->request->getQuery('keyUsuario');

            $currentLogedID=$this->request->getAttribute('identity')['id'];
            $currentLogedRole=$this->request->getAttribute('identity')['role'];
            if($currentLogedRole!='admin'){//Es protectora
                $allAnimalShelter = $this->getTableLocator()->get('AnimalShelter');

                $AnimalShelterUserID=$allAnimalShelter->find()->where(['user_id'=>$currentLogedID])->select('animal_id');
                if($keyAnimal||$keyUsuario){
        
                    $Adopcion_animal = $this->AnimalAdoption->find('all', ['limit' => 200])->where(['User.username like'=>'%'.$keyUsuario.'%','Animal.name like'=>'%'.$keyAnimal.'%','animal_id IN'=>$AnimalShelterUserID]);
                }else{
                    $Adopcion_animal = $this->AnimalAdoption->find('all')->where(['animal_id IN '=>$AnimalShelterUserID]);

                }
            }else{
                if($keyAnimal||$keyUsuario){
        
                    $Adopcion_animal = $this->AnimalAdoption->find('all', ['limit' => 200])->where(['User.username like'=>'%'.$keyUsuario.'%','Animal.name like'=>'%'.$keyAnimal.'%']);
                }else{
                    $Adopcion_animal = $this->AnimalAdoption;
        
                }
            }


            $animalAdoption = $this->paginate($Adopcion_animal,['contain' => ['User', 'Animal'], 'order' => ['id'=>'desc']]);

            $this->set(compact('animalAdoption'));
        }else{
            return $this->redirect(['controller' => 'User', 'action' => 'login']);
        }
    }

    /**
     * View method
     *
     * @param string|null $id Animal Adoption id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $animalAdoption = $this->AnimalAdoption->get($id, [
            'contain' => ['User', 'Animal'],
        ]);
        $this->set(compact('animalAdoption'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $animalAdoption = $this->AnimalAdoption->newEmptyEntity();

        if ($this->request->is('post')) {
            $animalAdoption = $this->AnimalAdoption->patchEntity($animalAdoption, $this->request->getData());

            if ($this->AnimalAdoption->save($animalAdoption)) {
                $this->Flash->success(__('La adopción se ha añadido con exito.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La adopción no se ha podido añadir, por favor intentalo de nuevo.'));
        }

        $user = $this->AnimalAdoption->User->find('list', ['limit' => 200])->all();
        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserROLE =$currentUser['role']; 

        if ($currentUserROLE=='admin'){
            $animal = $this->AnimalAdoption->Animal->find('list', ['limit' => 200])->all();
        }else{
            $allAnimalShelter = $this->getTableLocator()->get('AnimalShelter');
            $currentAnimalShelter=$allAnimalShelter->find()->where(['user_id'=>$currentUserID])->select('animal_id'); //lista de entradas de animal
            $animal = $this->AnimalAdoption->Animal->find('list', ['limit' => 200])->where(['id IN'=>$currentAnimalShelter]);
        }
        $this->set(compact('animalAdoption', 'user', 'animal'));

    }
    
    /**
     * Edit method
     *
     * @param string|null $id Animal Adoption id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $animalAdoption = $this->AnimalAdoption->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $animalAdoption = $this->AnimalAdoption->patchEntity($animalAdoption, $this->request->getData());
            if ($this->AnimalAdoption->save($animalAdoption)) {
                $this->Flash->success(__('La adopción ha sido editada correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La adopción no se ha podido editar, por favor intentalo de nuevo.'));
        }

        $user = $this->AnimalAdoption->User->find('list', ['limit' => 200])->all();
        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserROLE =$currentUser['role']; 

        if ($currentUserROLE=='admin'){
            $animal = $this->AnimalAdoption->Animal->find('list', ['limit' => 200])->all();
        }else{
            $allAnimalShelter = $this->getTableLocator()->get('AnimalShelter');
            $currentAnimalShelter=$allAnimalShelter->find()->where(['user_id'=>$currentUserID])->select('animal_id'); //lista de entradas de animal
            $animal = $this->AnimalAdoption->Animal->find('list', ['limit' => 200])->where(['id IN'=>$currentAnimalShelter]);
        }
        $allAnimal = $this->getTableLocator()->get('Animal');
        $AnimalID=$animalAdoption->animal_id;
        $AnimalImage=$allAnimal->find()->where(['id'=>$AnimalID])->select('image')->first();
        $AnimalImg=$AnimalImage['image']; 
        $this->set(compact('animalAdoption', 'user', 'animal','AnimalImg'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Animal Adoption id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $animalAdoption = $this->AnimalAdoption->get($id);
        if ($this->AnimalAdoption->delete($animalAdoption)) {
            $this->Flash->success(__('Adopción eliminada.'));
        } else {
            $this->Flash->error(__('La adopción no se ha podido eliminar, por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
