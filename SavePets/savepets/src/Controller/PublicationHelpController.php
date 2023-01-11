<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationHelp Controller
 *
 * @property \App\Model\Table\PublicationHelpTable $PublicationHelp
 * @method \App\Model\Entity\PublicationHelp[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationHelpController extends AppController
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

       $keyCategoria = $this->request->getQuery('keyCategoria');

       if($keyCategoria){
           $PublicationHelpShow = $this->PublicationHelp->find('all', ['limit' => 200])->where(['categorie like'=>'%'.$keyCategoria.'%']);
       }else{
           $PublicationHelpShow = $this->PublicationHelp;
       }

        $publicationHelp = $this->paginate($PublicationHelpShow,['contain'=>['Publication','User'], 'order' => ['id'=>'desc']]);

        $this->set(compact('publicationHelp'));
    }


    /**
     * View method
     *
     * @param string|null $id Publication Help id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationHelp = $this->PublicationHelp->get($id, [
            'contain' => ['Publication','User','Comment', 'Comment.User'],
        ]);

        $this->set(compact('publicationHelp'));
    }


    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationHelp = $this->PublicationHelp->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationHelp = $this->PublicationHelp->patchEntity($publicationHelp, $this->request->getData());
            if ($this->PublicationHelp->save($publicationHelp)) {
                $this->Flash->success(__('Publicado correctamente.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Ha habido un error al crear la publicación . Por favor intentalo de nuevo.'));
        }
        $this->set(compact('publicationHelp'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Help id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationHelp = $this->PublicationHelp->get($id, [
            'contain' => ['Publication','User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationHelp = $this->PublicationHelp->patchEntity($publicationHelp, $this->request->getData());
            if ($this->PublicationHelp->save($publicationHelp)) {
                $this->Flash->success(__('La publicación se ha actualizado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La publicación no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        $this->set(compact('publicationHelp'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Help id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationHelp = $this->PublicationHelp->get($id);

        if ($this->PublicationHelp->delete($publicationHelp)) {
            $this->Flash->success(__('Publicación eliminada.'));
        } else {
            $this->Flash->error(__('La publicación no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
