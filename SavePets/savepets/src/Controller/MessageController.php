<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Message Controller
 *
 * @property \App\Model\Table\MessageTable $Message
 * @method \App\Model\Entity\Message[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class MessageController extends AppController
{   
    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserRol =$currentUser['role']; //id usuario logeado
        if($currentUserRol=='admin'){//Es admin
            $allmessage = $this->Message;
        }else{
            $allmessage = $this->Message->find('all', ['limit' => 200])->where(['receiver_user_id' => $currentUserID]);
        }
        $message = $this->paginate($allmessage,['contain' => ['Transmitter','Receiver'], 'order' => ['id'=>'desc']]);

        $this->set(compact('message'));
    }

    /**
     * View method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $message = $this->Message->get($id, [
            'contain' => ['Transmitter','Receiver'],
        ]);

        $message->readed='yes';
        $this->Message->save($message);

        $this->set(compact('message'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $message = $this->Message->newEmptyEntity();
        if ($this->request->is('post')) {
            $message = $this->Message->patchEntity($message, $this->request->getData());
            if ($this->Message->save($message)) {
                $this->Flash->success(__('Mensaje enviado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El mensaje no se ha podido enviar. Por favor, intentalo de nuevo.'));
        }
        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserRol =$currentUser['role']; //id usuario logeado
        if($currentUserRol=='standar'){
        $user = $this->Message->User->find('list', ['limit' => 200])->where(['or'=>[['role'=>'admin'],['role'=>'shelter']]]);
        }else{
            $user = $this->Message->User->find('list', ['limit' => 200])->all();
        }
        $this->set(compact('message', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
      */
    // public function edit($id = null)
    // {
    //     $message = $this->Message->get($id, [
    //         'contain' => [],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $message = $this->Message->patchEntity($message, $this->request->getData());
    //         if ($this->Message->save($message)) {
    //             $this->Flash->success(__('The message has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The message could not be saved. Please, try again.'));
    //     }
    //     $user = $this->Message->User->find('list', ['limit' => 200])->all();
    //     $this->set(compact('message', 'user'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Message id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $message = $this->Message->get($id);
    //     if ($this->Message->delete($message)) {
    //         $this->Flash->success(__('The message has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The message could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
