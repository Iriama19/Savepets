<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationAdoption Controller
 *
 * @property \App\Model\Table\PublicationAdoptionTable $PublicationAdoption
 * @method \App\Model\Entity\PublicationAdoption[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationAdoptionController extends AppController
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

        $keyUrgente = $this->request->getQuery('keyUrgente');

        if($keyUrgente){
            $PublicationAdoptionShow = $this->PublicationAdoption->find('all', ['limit' => 200])->where(['urgent like'=>'%'.$keyUrgente.'%']);
        }else{
            $PublicationAdoptionShow = $this->PublicationAdoption;
        }
 
 
        $this->paginate = [
            'contain' => ['Publication', 'Animal', 'User'],
        ];
        $publicationAdoption = $this->paginate($PublicationAdoptionShow, ['order' => ['id'=>'desc']]);

        $this->set(compact('publicationAdoption'));
    }

    /**
     * View method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationAdoption = $this->PublicationAdoption->get($id, [
            'contain' => ['Publication', 'Animal', 'User','Comment', 'Comment.User'],
        ]);

        $this->set(compact('publicationAdoption'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationAdoption = $this->PublicationAdoption->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationAdoption = $this->PublicationAdoption->patchEntity($publicationAdoption, $this->request->getData());
            if ($this->PublicationAdoption->save($publicationAdoption)) {
                $this->Flash->success(__('Publicado correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ha habido un error al crear la publicación . Por favor intentalo de nuevo.'));
        }
        $publication = $this->PublicationAdoption->Publication->find('list', ['limit' => 200])->all();
        $animal = $this->PublicationAdoption->Animal->find('list', ['limit' => 200])->all();
        $user = $this->PublicationAdoption->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationAdoption', 'publication', 'animal', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationAdoption = $this->PublicationAdoption->get($id, [
            'contain' => ['Publication', 'Animal', 'User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationAdoption = $this->PublicationAdoption->patchEntity($publicationAdoption, $this->request->getData());
            if ($this->PublicationAdoption->save($publicationAdoption)) {
                $this->Flash->success(__('La publicación se ha actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La publicación no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        $publication = $this->PublicationAdoption->Publication->find('list', ['limit' => 200])->all();
        $animal = $this->PublicationAdoption->Animal->find('list', ['limit' => 200])->all();
        $user = $this->PublicationAdoption->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationAdoption', 'publication', 'animal', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Adoption id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationAdoption = $this->PublicationAdoption->get($id);
        if ($this->PublicationAdoption->delete($publicationAdoption)) {
            $this->Flash->success(__('Publicación eliminada.'));
        } else {
            $this->Flash->error(__('La publicación no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
