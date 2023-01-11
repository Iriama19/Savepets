<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Address Controller
 *
 * @property \App\Model\Table\AddressTable $Address
 * @method \App\Model\Entity\Addres[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class AddressController extends AppController
{
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Authentication->addUnauthenticatedActions([]);
        
    }
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
            $addres = $this->Address->find('all', ['limit' => 200])->where(['User.username like'=>'%'.$keyUsername.'%','User.role like'=>'%'.$keyRole.'%']);
        }else{
            $addres = $this->Address;
        }

        $address = $this->paginate($addres,['contain'=>['User']]);

        $this->set(compact('address'));
    }

    /**
     * View method
     *
     * @param string|null $id Addres id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
         $addres = $this->Address->get($id, [
            'contain' => ['User'],
        ]);
        //  $addres = $this->Address->get($id, [
        //     'contain' => ['PublicationStray'],
        // ]);

        $this->set(compact('addres'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $addres = $this->Address->newEmptyEntity();

        if ($this->request->is('post')) {
            $address = $this->Address->patchEntity($addres, $this->request->getData());
            if ($this->Address->save($address)) {
                $this->Flash->success(__('Usuario registrado.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('Error al registrar usuario, por favor intentalo de nuevo.'));
        }
         $this->set(compact('addres'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Addres id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
         $addres = $this->Address->get($id, [
             'contain' => ['User'],
         ]);



        //$addres = $this->Address->get($id);

        if ($this->request->is(['patch', 'post', 'put'])) {
            $address = $this->Address->patchEntity($addres, $this->request->getData());

            if ($this->Address->save($address)) {
                $this->Flash->success(__('Usuario editado con exito.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('El usuario no se ha podido editar, por favor intentalo de nuevo.'));
        }
        $this->set(compact('addres'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Addres id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null,$controlador, $CurrentPublicationStray_id =null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $addres = $this->Address->get($id);


        if($controlador!='Event'){
            $allPublicationStrayAddres = $this->getTableLocator()->get('PublicationStrayAddress');
            $PublicationStrayAddress=$allPublicationStrayAddres->find()->where(['addres_id'=>$id])->select('image')->first();//busco si es una publicación stray y cojo imagen
            
            if(!empty($PublicationStrayAddress) || $PublicationStrayAddress!= NULL){
                $imgpath = WWW_ROOT.'img'.DS.$PublicationStrayAddress->image;
                $imageStrayAnimalAddress=$PublicationStrayAddress->image;
            }
        }

        if ($this->Address->delete($addres)) {
            if($controlador!='Event'){

                if(!empty($PublicationStrayAddress) || $PublicationStrayAddress!= NULL){ 

                    if(file_exists($imgpath) ){
                        if(!empty($imageStrayAnimalAddress) && !preg_match('/^addresstrayanimal-img\/$/',$imageStrayAnimalAddress)){
                        unlink($imgpath);
                        }
                    }
                }
            }
            $this->Flash->success(__('Se ha eliminado.'));
        } else {
            $this->Flash->error(__('No se ha podido eliminar, por favor intentalo de nuevo.'));
        }

        if($controlador=='Event'){
        return $this->redirect(['action' => 'index', 'controller' =>'Event']);
        }else{
            return $this->redirect(['action' => 'index',$CurrentPublicationStray_id, 'controller' =>$controlador]);
        }
    }
}
