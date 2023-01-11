<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FosterListUser Controller
 *
 * @property \App\Model\Table\FosterListUserTable $FosterListUser
 * @method \App\Model\Entity\FosterListUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FosterListUserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $fosterListUser = $this->paginate($this->FosterListUser,['contain'=>['FosterList','FosterList.User','User'], 'order' => ['id'=>'desc']]);

        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $currentUserRol =$currentUser['role']; //rol usuario logeado
        $keyEspecie = $this->request->getQuery('keyEspecie');

        if($keyEspecie){
            $fosterlista = $this->FosterListUser->find('all', ['limit' => 200])->where(['specie like'=>'%'.$keyEspecie.'%']);
        }else{
            $fosterlista=$this->FosterListUser;
        }

        if($currentUserRol=='admin'){//Si es admin ve todas

                $fosterListUser = $this->paginate($fosterlista,['contain'=>['FosterList','FosterList.User','User'], 'order' => ['id'=>'desc']]);
        }elseif($currentUserRol=='shelter'){//Si es protectora ve los que tienen su fosterList

            $allFosterList = $this->getTableLocator()->get('FosterList');
            $ShelterFosterID = $allFosterList->find()->where(['user_id'=>$currentUserID])->select('id')->first();

            $allFosterShelter = $fosterlista->find('all', ['limit' => 200])->where(['foster_list_id'=>$ShelterFosterID['id']]);

            $fosterListUser = $this->paginate($allFosterShelter,['contain'=>['FosterList','FosterList.User','User'], 'order' => ['id'=>'desc']]);

        }else{//Si es usuario estandar ve las que esta apuntado 
            $allFosterUser = $fosterlista->find('all', ['limit' => 200])->where(['User.id'=>$currentUserID]);
            $fosterListUser = $this->paginate($allFosterUser,['contain'=>['FosterList','FosterList.User','User'], 'order' => ['id'=>'desc']]);
        }

        $this->set(compact('fosterListUser'));
    }

    /**
     * View method
     *
     * @param string|null $id Foster List User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fosterListUser = $this->FosterListUser->get($id, [
            'contain' => ['FosterList','FosterList.User','User'],
        ]);

        $this->set(compact('fosterListUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($foster= null)
    {

        $fosterListUser = $this->FosterListUser->newEmptyEntity();

        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado
        $existe = $this->FosterListUser->find('all', ['limit' => 200])->where(['user_id'=>$currentUserID, 'foster_list_id'=>$foster])->first();
        if($existe != NULL){
            $this->Flash->success(__('Ya estas en esta lista de acogida.'));
            return $this->redirect(['action' => 'index', 'controller' => 'FosterListUser']);
        }
        if ($this->request->is('post')) {

            $fosterListUser = $this->FosterListUser->patchEntity($fosterListUser, $this->request->getData());

            if ($this->FosterListUser->save($fosterListUser)) {
                $this->Flash->success(__('Te has unido correctamente.'));

                return $this->redirect(['action' => 'index', 'controller' => 'FosterListUser']);
            }
            $this->Flash->error(__('No te has podido unir a la lista de acogida. Por favor, intentalo de nuevo.'));
        }

        $this->set(compact('fosterListUser','foster'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Foster List User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $fosterListUser = $this->FosterListUser->get($id, [
            'contain' => ['FosterList','FosterList.User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $fosterListUser = $this->FosterListUser->patchEntity($fosterListUser, $this->request->getData());
            if ($this->FosterListUser->save($fosterListUser)) {
                $this->Flash->success(__('Tu unión a la lista de acogida se ha editado.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Tu unión a la lista de acogida no se ha podido guardar. Por favor intentalo de nuevo.'));
        }
        $this->set(compact('fosterListUser'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Foster List User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fosterListUser = $this->FosterListUser->get($id);
        if ($this->FosterListUser->delete($fosterListUser)) {
            $this->Flash->success(__('Te has borrado de la lista de acogida.'));
        } else {
            $this->Flash->error(__('No te has podido borrar de la lista de acogida. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
