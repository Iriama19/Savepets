<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * AnimalShelter Controller
 *
 * @property \App\Model\Table\AnimalShelterTable $AnimalShelter
 * @method \App\Model\Entity\AnimalShelter[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AnimalShelterController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['view','index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['User', 'Animal'],
        ];
        $animalShelter = $this->paginate($this->AnimalShelter,['order' => ['id'=>'desc']]);

        $this->set(compact('animalShelter'));
    }

    /**
     * View method
     *
     * @param string|null $id Animal Shelter id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $animalShelter = $this->AnimalShelter->get($id, [
            'contain' => ['User', 'Animal'],
        ]);

        $this->set(compact('animalShelter'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $animalShelter = $this->AnimalShelter->newEmptyEntity();
        if ($this->request->is('post')) {
            $animalShelter = $this->AnimalShelter->patchEntity($animalShelter, $this->request->getData());
            if ($this->AnimalShelter->save($animalShelter)) {
                $this->Flash->success(__('La estancia en la protectora se ha añadido.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La estancia en la protectora no se ha podido añadir, por favor intentalo de nuevo.'));
        }
        $user = $this->AnimalShelter->User->find('list', ['limit' => 200])->all();
        $animal = $this->AnimalShelter->Animal->find('list', ['limit' => 200])->all();
        $this->set(compact('animalShelter', 'user', 'animal'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Animal Shelter id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $animalShelter = $this->AnimalShelter->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $animalShelter = $this->AnimalShelter->patchEntity($animalShelter, $this->request->getData());
            if ($this->AnimalShelter->save($animalShelter)) {
                $this->Flash->success(__('La estancia en la protectora se ha editado correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La estancia en la protectora no se ha podido editar, por favor intentalo de nuevo.'));
        }
        $user = $this->AnimalShelter->User->find('list', ['limit' => 200])->all();
        $animal = $this->AnimalShelter->Animal->find('list', ['limit' => 200])->all();
        $this->set(compact('animalShelter', 'user', 'animal'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Animal Shelter id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $animalShelter = $this->AnimalShelter->get($id);
        if ($this->AnimalShelter->delete($animalShelter)) {
            $this->Flash->success(__('La estancia en la protectora se ha eliminado.'));
        } else {
            $this->Flash->error(__('La estancia en la protectora no se ha podido eliminar, por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
