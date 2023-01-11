<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PublicationStray Controller
 *
 * @property \App\Model\Table\PublicationStrayTable $PublicationStray
 * @method \App\Model\Entity\PublicationStray[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationStrayController extends AppController
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
        $keyProvincia = $this->request->getQuery('keyProvincia');
        $keyCiudad = $this->request->getQuery('keyCiudad');
        $keyPais = $this->request->getQuery('keyPais');

    if($keyProvincia || $keyCiudad || $keyPais){
        $allPublicationStrayAddress = $this->getTableLocator()->get('PublicationStrayAddress');
        $allAddress = $this->getTableLocator()->get('Address');

        $allAddressIDCityProvince = $allAddress->find( 'all')->where(['city like'=>'%'.$keyCiudad.'%','province like'=>'%'.$keyProvincia.'%','country like'=>'%'.$keyPais.'%'])->select('id');
        $PublicationStrayIDCityProvinceCountry = $allPublicationStrayAddress->find( 'all')->where(['addres_id IN'=>$allAddressIDCityProvince])->select('publication_stray_id');

        if($keyUrgente){
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['PublicationStray.urgent like'=>'%'.$keyUrgente.'%', 'PublicationStray.id'=>$PublicationStrayIDCityProvinceCountry]);

        }else{
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['PublicationStray.id'=>$PublicationStrayIDCityProvinceCountry]);

        } 
    }else{
        if($keyUrgente){
            $PublicationStrayShow = $this->PublicationStray->find('all', ['limit' => 200])->where(['urgent like'=>'%'.$keyUrgente.'%']);
        }else{
            $PublicationStrayShow = $this->PublicationStray;
        } 
    }
        $publicationStray = $this->paginate($PublicationStrayShow,['contain'=>['Publication','User'], 'order' => ['id'=>'desc']]);

        $this->set(compact('publicationStray'));
    }

    /**
     * View method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publicationStray = $this->PublicationStray->get($id,['contain'=>['Publication','User','Comment', 'Comment.User']]);

        $this->set(compact('publicationStray'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publicationStray = $this->PublicationStray->newEmptyEntity();
        if ($this->request->is('post')) {
            $publicationStray = $this->PublicationStray->patchEntity($publicationStray, $this->request->getData());
            if(!$publicationStray->getErrors){
                $image = $this->request->getData('image_file');
                $name=null;

                if($image !=NULL){
                    $name  = $image->getClientFilename();
                }
                if( !is_dir(WWW_ROOT.'img'.DS.'strayanimal-img') ){
                    mkdir(WWW_ROOT.'img'.DS.'strayanimal-img',0775);
                }
                if($name){
                    $targetPath = WWW_ROOT.'img'.DS.'strayanimal-img'.DS.$name;

                    $image->moveTo($targetPath);
                    
                    $publicationStray->image = 'strayanimal-img/'.$name;
                }
                

                if ($this->PublicationStray->save($publicationStray)) {
                    $this->Flash->success(__('Publicado correctamente.'));
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('Ha habido un error al crear la publicación . Por favor intentalo de nuevo.'));
        }
        $address = $this->PublicationStray->Address->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStray', 'address'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $publicationStray = $this->PublicationStray->get($id,['contain'=>['Publication','User']]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publicationStray = $this->PublicationStray->patchEntity($publicationStray, $this->request->getData());
            $image = $this->request->getData('change_image');
            $name=null;

            if($image !=NULL){
                $name  = $image->getClientFilename();
            }
            if (!$publicationStray->getErrors) {
                $image = $this->request->getData('change_image');
  
                if (!is_dir(WWW_ROOT . 'img' . DS . 'strayanimal-img')){
                    mkdir(WWW_ROOT . 'img' . DS . 'strayanimal-img', 0775);
                }
                if ($name){
                    $targetPath = WWW_ROOT . 'img' . DS . 'strayanimal-img' . DS . $name;
                    $imgpath = WWW_ROOT . 'img' . DS . $publicationStray->image;
                    if (file_exists($imgpath)&& !preg_match('/^\/var\/www\/html\/savepets\/webroot\/img\/strayanimal-img\/$/',$imgpath)) {
                        unlink($imgpath);
                    }
                    $image->moveTo($targetPath);
                    $publicationStray->image = 'strayanimal-img/' . $name;                    
                }   
                
                if ($this->PublicationStray->save($publicationStray)) {
                    $this->Flash->success(__('La publicación se ha actualizado.'));

                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('La publicación no se ha podido actualizar. Por favor intentalo de nuevo.'));
        }
        //$address = $this->PublicationStray->Address->find('list', ['limit' => 200])->all();
        $this->set(compact('publicationStray'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication Stray id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $publicationStray = $this->PublicationStray->get($id);
        $imgpath = WWW_ROOT.'img'.DS.$PublicationStray->image;


        if ($this->PublicationStray->delete($publicationStray)) {
            if(file_exists($imgpath) ){
                $imageStrayAnimal=$PublicationStray->image;
                if(!empty($imageStrayAnimal)&& !preg_match('/^strayanimal-img\/$/',$imageStrayAnimal)){
                    unlink($imgpath);
                }
            }
            $this->Flash->success(__('Publicación de perdidos eliminada.'));
        } else {
            $this->Flash->error(__('La publicación de perdidos no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
