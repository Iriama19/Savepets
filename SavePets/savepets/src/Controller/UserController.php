<?php
declare(strict_types=1);

namespace App\Controller;


/**
 * User Controller
 *
 * @property \App\Model\Table\UserTable $User
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class UserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {     
        $keyUsername = $this->request->getQuery('key');
        $keyRole = $this->request->getQuery('keyRole');

        if($keyUsername||$keyRole){
            $use = $this->User->find('all', ['limit' => 200])->where(['username like'=>'%'.$keyUsername.'%','role like'=>'%'.$keyRole.'%']);
        }else{
            $use = $this->User;
        }
        if($this->Authentication->getIdentity()){

            $currentUser =$this->request->getAttribute('identity');
            $currentUserID =$currentUser['id']; //id usuario logeado
            $currentUserRol =$currentUser['role']; //rol usuario logeado
            if ($currentUserRol=='admin'|| $currentUserRol=='shelter'){
                $user = $this->paginate($use, ['order' => ['id'=>'desc']]);
            }else{
                $alluse = $use->find('all', ['limit' => 200])->where(['or'=>[['role'=>'admin'],['role'=>'shelter'],['id'=>$currentUserID]]]);
                $user = $this->paginate($alluse, ['order' => ['id'=>'desc']]);
            }
        }else{//Si es usuario estandar ve las que esta protectoras y a si mismo 
            $alluse = $use->find('all', ['limit' => 200])->where(['or'=>[['role'=>'admin'],['role'=>'shelter']]]);
            $user = $this->paginate($alluse, ['order' => ['id'=>'desc']]);

        }

        $this->set(compact('user'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {

        $user = $this->User->get($id, [
            'contain' => ['Address','FeatureUser'],
        ]);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {

        $user = $this->User->newEmptyEntity();

        if ($this->request->is('post')) {

            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {

                $this->Flash->success(__('Usuario registrado.'));

                return $this->redirect(['action' => 'login']);
            }
            
            $this->Flash->error(__('Error al registrar usuario, por favor intentalo de nuevo.'));
        }
         $this->set(compact('user'));
    }


    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->User->get($id, [
            'contain' => ['Address','FeatureUser'],
        ]);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->User->patchEntity($user, $this->request->getData());
            if ($this->User->save($user)) {
                $this->Flash->success(__('Usuario modificado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no se ha podido modificar, por favor vuelva a intentarlo.'));
        }

        
        $this->set(compact('user'));
    }

    public function logout()
    {
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {
            $this->Authentication->logout();
            return $this->redirect(['controller' => 'User', 'action' => 'login']);
        }
    }
    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->User->get($id);
        $user['username']=__('Anonimo').$id;
        $user['password']=__('Anonimo').$id;
        $user = $this->User->patchEntity($user, $this->request->getData());

        if ($this->User->save($user)) {
            $this->Flash->success(__('El usuario se ha eliminado.'));
            if($this->request->getAttribute('identity')['id']==$id){
                return $this->redirect(['controller' => 'User', 'action' => 'logout']);
            }
        } else {
            $this->Flash->error(__('El usuario no se ha podido eliminar, por favor intentalo de nuevo.'));
        }
        
        return $this->redirect(['controller' => 'User', 'action' => 'index']);

    }


    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configure the login action to not require authentication, preventing
        // the infinite redirect loop issue
       // $this->Authentication->addUnauthenticatedActions(['login']);
        $this->Authentication->addUnauthenticatedActions(['login', 'add','index']);
    }

    public function login()
    {
        $this->request->allowMethod(['get', 'post']);
        $result = $this->Authentication->getResult();
        // regardless of POST or GET, redirect if user is logged in
        if ($result && $result->isValid()) {

            // redirect to /articles after login success
            // $redirect = $this->request->getQuery('redirect', [
            //     'controller' => 'Address',
            //     'action' => 'index',
            // ]);
            return $this->redirect('/');
        }
        // display error if user submitted and authentication failed
        if ($this->request->is('post') && !$result->isValid()) {
            $this->Flash->error(__('Alias de usuario o contraseña incorrecta.'));
        }
    }

}

