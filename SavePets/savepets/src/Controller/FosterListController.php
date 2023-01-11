<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FosterList Controller
 *
 * @property \App\Model\Table\FosterListTable $FosterList
 * @method \App\Model\Entity\FosterList[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FosterListController extends AppController
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

        $keyUrgente = $this->request->getQuery('keyUrgente');
        $keyProvincia = $this->request->getQuery('keyProvincia');
        $keyCiudad = $this->request->getQuery('keyCiudad');
        $keyPais = $this->request->getQuery('keyPais');

    if($keyProvincia || $keyCiudad || $keyPais){
        $allAddress = $this->getTableLocator()->get('Address');
        $allUser = $this->getTableLocator()->get('Address');

        $allAddressIDCityProvinceCountry = $allAddress->find( 'all')->where(['city like'=>'%'.$keyCiudad.'%','province like'=>'%'.$keyProvincia.'%','country like'=>'%'.$keyPais.'%'])->select('id');
        $UserListCityProvinceCountry = $allUser->find( 'all')->where(['addres_id IN'=>$allAddressIDCityProvinceCountry])->select('id');
        $FosterListCityProvinceCountry = $this->FosterList->find( 'all')->where(['user_id IN'=>$UserListCityProvinceCountry]);

        $fosterList = $this->paginate($FosterListCityProvinceCountry,['contain' => ['User'], 'order' => ['id'=>'desc']]);

    }else{
        $fosterList = $this->paginate($this->FosterList,['contain' => ['User'], 'order' => ['id'=>'desc']]);
    }

        $this->set(compact('fosterList'));
    }

    /**
     * View method
     *
     * @param string|null $id Foster List id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $fosterList = $this->FosterList->get($id, [
            'contain' => ['User'],
        ]);

        $currentUser =$this->request->getAttribute('identity');
        $currentUserID =$currentUser['id']; //id usuario logeado

                //existe ya un usuario el usuario en la lista de acogida
        $allFosterListUser = $this->getTableLocator()->get('FosterListUser');
        $existe = $allFosterListUser->find('all', ['limit' => 200])->where(['user_id'=>$currentUserID, 'foster_list_id'=>$id])->first();
        
        $userID = $this->FosterList->User->find('all', ['limit' => 200])->where(['id'=>$currentUserID])->first();//Localizo la dirección
        $address_id=$userID['addres_id'];//Cojo cual es el id de la dirección

        $allAddress = $this->getTableLocator()->get('Address');
        $address = $allAddress->find('all', ['limit' => 200])->where(['id'=>$address_id])->first();//Cojo direcion

        $this->set(compact('fosterList','address','existe'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $fosterList = $this->FosterList->newEmptyEntity();
        if ($this->request->is('post')) {
            $fosterList = $this->FosterList->patchEntity($fosterList, $this->request->getData());
            if ($this->FosterList->save($fosterList)) {
                $this->Flash->success(__('Lista de acogida creada.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La lista de acogida no se ha podido crear. Por favor, intentalo de nuevo.'));
        }
        $user = $this->FosterList->User->find('list', ['limit' => 200])->all();
        $this->set(compact('fosterList', 'user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Foster List id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    */
    // public function edit($id = null)
    // {
    //     $fosterList = $this->FosterList->get($id, [
    //         'contain' => ['User'],
    //     ]);
    //     if ($this->request->is(['patch', 'post', 'put'])) {
    //         $fosterList = $this->FosterList->patchEntity($fosterList, $this->request->getData());
    //         if ($this->FosterList->save($fosterList)) {
    //             $this->Flash->success(__('The foster list has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The foster list could not be saved. Please, try again.'));
    //     }
    //     $user = $this->FosterList->User->find('list', ['limit' => 200])->all();
    //     $this->set(compact('fosterList', 'user'));
    // }

    /**
     * Delete method
     *
     * @param string|null $id Foster List id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $fosterList = $this->FosterList->get($id);
        if ($this->FosterList->delete($fosterList)) {
            $this->Flash->success(__('La lista de acogida se ha eliminado.'));
        } else {
            $this->Flash->error(__('La lista de acogida no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
