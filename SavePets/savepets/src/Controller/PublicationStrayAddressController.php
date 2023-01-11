<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationStrayAddress Controller
 *
 * @property \App\Model\Table\PublicationStrayAddressTable $PublicationStrayAddress
 * @method \App\Model\Entity\PublicationStrayAddres[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationStrayAddressController extends AppController
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
    public function index($CurrentPublicationStray_id=null)
    {  
        if(!empty($CurrentPublicationStray_id)||$CurrentPublicationStray_id!=NULL){

            $PublicationStrayAddressShow = $this->PublicationStrayAddress->find('all', ['limit' => 200])->where(['publication_stray_id'=>$CurrentPublicationStray_id]);

        }else{
            $PublicationStrayAddressShow = $this->PublicationStrayAddress;
        } 
        $publicationStrayAddress = $this->paginate($PublicationStrayAddressShow,['contain' => ['PublicationStray', 'Address', 'User'], 'order' => ['id'=>'desc']]);


        if(!empty($CurrentPublicationStray_id)||$CurrentPublicationStray_id!=NULL){
            $CurrentPublicationStray_id=$CurrentPublicationStray_id;

            $this->set(compact('publicationStrayAddress','CurrentPublicationStray_id'));
        }else{
            $this->set(compact('publicationStrayAddress'));

        }
    }

    /**
     * View method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->get($id, [
            'contain' => ['PublicationStray', 'Address', 'User'],
        ]);
        $this->set(compact('publicationStrayAddres'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add($CurrentPublicationStray_id=null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationStrayAddres = $this->PublicationStrayAddress->patchEntity($publicationStrayAddres, $this->request->getData());
            if(!$publicationStrayAddres->getErrors){
                $image = $this->request->getData('image_file');
                $name=null;

                if($image !=NULL){
                    $name  = $image->getClientFilename();
                }
                if( !is_dir(WWW_ROOT.'img'.DS.'addresstrayanimal-img') ){
                    mkdir(WWW_ROOT.'img'.DS.'addresstrayanimal-img',0775);
                }
               if($name){

                    $targetPath = WWW_ROOT.'img'.DS.'addresstrayanimal-img'.DS.$name;

                    $image->moveTo($targetPath);
                
                    $publicationStrayAddres->image = 'addresstrayanimal-img/'.$name;
                }
                if ($this->PublicationStrayAddress->save($publicationStrayAddres)) {
                    $this->Flash->success(__('La dirección de la publicación de animal perdido se ha añadido.'));
                    return $this->redirect(['action' => 'index',$CurrentPublicationStray_id]);
                }
            }
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido añadir. Por favor intentalo de nuevo.'));
        }
         //$publicationStray = $this->PublicationStrayAddress->PublicationStray->find('list', ['limit' => 200])->all();
       // $address = $this->PublicationStrayAddress->Address->find('list', ['limit' => 200])->all();
      //  $user = $this->PublicationStrayAddress->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStrayAddres', 'CurrentPublicationStray_id'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationStrayAddres = $this->PublicationStrayAddress->get($id, [
            'contain' => ['PublicationStray', 'Address', 'User'],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationStrayAddres = $this->PublicationStrayAddress->patchEntity($publicationStrayAddres, $this->request->getData());

            if (!$publicationStrayAddres->getErrors) {
                $image = $this->request->getData('change_image');
                $name=null;

                if($image !=NULL){
                    $name  = $image->getClientFilename();
                }                     
                if (!is_dir(WWW_ROOT . 'img' . DS . 'addresstrayanimal-img')){
                    mkdir(WWW_ROOT . 'img' . DS . 'addresstrayanimal-img', 0775);
                }
                if ($name){

                    $targetPath = WWW_ROOT . 'img' . DS . 'addresstrayanimal-img' . DS . $name;

                    $imgpath = WWW_ROOT . 'img' . DS . $publicationStrayAddres->image;
                    if (file_exists($imgpath) && !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/addresstrayanimal-img\/$/',$imgpath)) {
                        unlink($imgpath);
                    }

                    $image->moveTo($targetPath);
                    $publicationStrayAddres->image = 'addresstrayanimal-img/' . $name;
                    
                }   

                if ($this->PublicationStrayAddress->save($publicationStrayAddres)) {
                    $this->Flash->success(__('La dirección de la publicación de animal perdido se ha actualizado.'));
                    return $this->redirect(['action' => 'index',$publicationStrayAddres->publication_stray_id]);
                }
            }
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido actualizar. Por favor intentalo de nuevo.'));
        }
        $publicationStray = $this->PublicationStrayAddress->PublicationStray->find('list', ['limit' => 200])->all();
        $address = $this->PublicationStrayAddress->Address->find('list', ['limit' => 200])->all();
        $user = $this->PublicationStrayAddress->User->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStrayAddres', 'publicationStray', 'address', 'user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Stray Addres id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationStrayAddres = $this->PublicationStrayAddress->get($id);
        $imgpath = WWW_ROOT.'img'.DS.$publicationStrayAddres->image;

        if ($this->PublicationStrayAddress->delete($publicationStrayAddres)) {
            if(file_exists($imgpath) ){
                $imageStrayAnimalAddress=$publicationStrayAddres->image;
                if(!empty($imageStrayAnimalAddress)&& !preg_match('/^addresstrayanimal-img\/$/',$imageStrayAnimalAddress)){
                    unlink($imgpath);
                }
            }
            $this->Flash->success(__('La dirección de la publicación de animal perdido se ha borrado.'));
        } else {
            $this->Flash->error(__('La dirección de la publicación de animal perdido se ha no podido borrar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index',$publicationStrayAddres->publication_stray_id]);
    }
}
