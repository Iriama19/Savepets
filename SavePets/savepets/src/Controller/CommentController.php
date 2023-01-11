<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Comment Controller
 *
 * @property \App\Model\Table\CommentTable $Comment
 * @method \App\Model\Entity\Comment[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class CommentController extends AppController
{    
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions(['index']);
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $comment = $this->paginate($this->Comment);

        $this->set(compact('comment'));
    }

    /**
     * View method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null, $currentPublicacion =null,$currenTypeIDPublicacion=null,$currenTypePublicacion=null)
    // {

    //     $comment = $this->Comment->get($id, [
    //         'contain' =>['Publication','User'],
    //     ]);

    //     $this->set(compact('comment','currentPublicacion'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($currentPublicacion =null,$currenTypeIDPublicacion=null,$currenTypePublicacion=null)
    {

        $comment = $this->Comment->newEmptyEntity();
        if ($this->request->is('post')) {
            $comment = $this->Comment->patchEntity($comment, $this->request->getData());
            if ($regreso=$this->Comment->save($comment)) {
                $this->Flash->success(__('Comentario publicado.'));

                return $this->redirect(['action'=>'view','controller'=>'Publication'.$currenTypePublicacion,$currenTypeIDPublicacion]);
            }
            $this->Flash->error(__('El comentario no se ha podido publicar. Por favor vuelve a intentarlo.'));
        }
        $this->set(compact('comment','currentPublicacion', 'currenTypePublicacion','currenTypeIDPublicacion'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null,$currentPublicacion =null,$currenTypeIDPublicacion=null,$currenTypePublicacion=null)
    {
        
        $comment = $this->Comment->get($id, [
            'contain' => ['Publication','User'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $comment = $this->Comment->patchEntity($comment, $this->request->getData());
            if ($this->Comment->save($comment)) {
                $this->Flash->success(__('Comentario actualizado.'));

                return $this->redirect(['action'=>'view','controller'=>'Publication'.$currenTypePublicacion,$currenTypeIDPublicacion]);
            }
            $this->Flash->error(__('El comentario no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        $this->set(compact('comment','currenTypePublicacion','currenTypeIDPublicacion'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Comment id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null,$currentPublicacion =null,$currenTypeIDPublicacion=null,$currenTypePublicacion=null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $comment = $this->Comment->get($id);
        if ($this->Comment->delete($comment)) {
            $this->Flash->success(__('Comentario eliminado.'));
        } else {
            $this->Flash->error(__('El comentario no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action'=>'view','controller'=>'Publication'.$currenTypePublicacion,$currenTypeIDPublicacion]);
    }
}
