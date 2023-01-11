<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Publication Controller
 *
 * @property \App\Model\Table\PublicationTable $Publication
 * @method \App\Model\Entity\Publication[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class PublicationController extends AppController
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
        $publication = $this->paginate($this->Publication);

        $this->set(compact('publication'));
    }

    /**
     * View method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $publication = $this->Publication->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('publication'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $publication = $this->Publication->newEmptyEntity();
        if ($this->request->is('post')) {
            $publication = $this->Publication->patchEntity($publication, $this->request->getData());
            if ($this->Publication->save($publication)) {
                $this->Flash->success(__('The publication has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The publication could not be saved. Please, try again.'));
        }
        $this->set(compact('publication'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        
        $publication = $this->Publication->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $publication = $this->Publication->patchEntity($publication, $this->request->getData());
            if ($this->Publication->save($publication)) {
                $this->Flash->success(__('The publication has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The publication could not be saved. Please, try again.'));
        }
        $this->set(compact('publication'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Publication id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
//     public function delete($id = null,$tipo=null)
//     {

//         $this->request->allowMethod(['post', 'delete']);
//         $publication = $this->Publication->get($id);

//         $allPublicationStray = $this->getTableLocator()->get('PublicationStray');
//         $PublicationStray=$allPublicationStray->find()->where(['publication_id'=>$id])->select('image')->first();//busco si es una publicación stray y cojo imagen
        
//         if(!empty($PublicationStray) || $PublicationStray!= NULL){
//             $imgpath = WWW_ROOT.'img'.DS.$PublicationStray->image;
//             $imageStrayAnimal=$PublicationStray->image;
//         }

//         if ($this->Publication->delete($publication)) {

//             if(!empty($PublicationStray) || $PublicationStray!= NULL){ 

//                 if(file_exists($imgpath) ){
//                     if(!empty($imageStrayAnimal) && !preg_match('/^strayanimal-img\/$/',$imageStrayAnimal)){
//                        unlink($imgpath);
//                     }
//             }
//         }
//             $this->Flash->success(__(' La publicación se ha eliminado.'));
//         } else {
//             $this->Flash->error(__('La publicación no se ha podido eliminar. Por favor intentalo de nuevo.'));
//         }

//         return $this->redirect(['action' => 'index', 'controller'=>'publication'.$tipo]);
//     }
// }

public function delete($id = null,$tipo=null)
    {

        $this->request->allowMethod(['post', 'delete']);
        $publication = $this->Publication->get($id);

        $allPublicationStray = $this->getTableLocator()->get('PublicationStray');
        $PublicationStray=$allPublicationStray->find()->where(['publication_id'=>$id])->select('image')->first();//busco si es una publicación stray y cojo imagen
        
        if(!empty($PublicationStray) || $PublicationStray!= NULL){
            $imgpath = WWW_ROOT.'img'.DS.$PublicationStray->image;
            $imageStrayAnimal=$PublicationStray->image;
        }

        $PublicationStrayID=$allPublicationStray->find()->where(['publication_id'=>$id])->select('id')->first();//busco si es una publicación stray y su id

        if($PublicationStrayID !=NULL){
            
            $allPublicationStrayAddress = $this->getTableLocator()->get('PublicationStrayAddress');
            $AddressID=$allPublicationStrayAddress->find()->where(['publication_stray_id'=>$PublicationStrayID['id']])->select('addres_id'); //Encuentro la dirección    
            if($AddressID!=NULL){//Si existe la dirección
                //Imagen
                $addresstable=$this->getTableLocator()->get('Address');    
                foreach($AddressID as $AddressaIDBorrarindiv){
                    $AddressaBorrar=$addresstable->find('all')->where(['id'=>$AddressaIDBorrarindiv['addres_id']])->first();
                    $AddressaBorrarIMG=$allPublicationStrayAddress->find()->where(['publication_stray_id'=>$PublicationStrayID['id']])->select('image')->first();
                    if(!empty($AddressaBorrarIMG) || $AddressaBorrarIMG!= NULL){
                        $imgpathAddressaBorrarIMG = WWW_ROOT.'img'.DS.$AddressaBorrarIMG->image;
                        $AddressaBorrarIMG=$AddressaBorrarIMG->image;
                    }
                    if ($addresstable->delete($AddressaBorrar)) {
                        if(!empty($AddressaBorrarIMG) || $AddressaBorrarIMG!= NULL){ 

                            if(file_exists($imgpathAddressaBorrarIMG) ){
                                if(!empty($AddressaBorrarIMG) && !preg_match('/^addresstrayanimal-img\/$/',$AddressaBorrarIMG)){
                                    unlink($imgpathAddressaBorrarIMG);
                                }
                            }
                        }
                    }
                }
            }
        }
        if ($this->Publication->delete($publication)) {

            if(!empty($PublicationStray) || $PublicationStray!= NULL){ 

                if(file_exists($imgpath) ){
                    if(!empty($imageStrayAnimal) && !preg_match('/^strayanimal-img\/$/',$imageStrayAnimal)){
                        unlink($imgpath);
                    }
                }
            }
            $this->Flash->success(__(' La publicación se ha eliminado.'));
        } else {
            $this->Flash->error(__('La publicación no se ha podido eliminar. Por favor intentalo de nuevo.'));
        }

       return $this->redirect(['action' => 'index', 'controller'=>'publication'.$tipo]);
    }
}
