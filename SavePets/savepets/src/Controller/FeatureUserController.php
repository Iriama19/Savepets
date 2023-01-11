<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * FeatureUser Controller
 *
 * @property \App\Model\Table\FeatureUserTable $FeatureUser
 * @method \App\Model\Entity\FeatureUser[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeatureUserController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['User', 'Feature'],
        ];
        $featureUser = $this->paginate($this->FeatureUser);

        $this->set(compact('featureUser'));
    }

    /**
     * View method
     *
     * @param string|null $id Feature User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $featureUser = $this->FeatureUser->get($id, [
            'contain' => ['User', 'Feature'],
        ]);

        $this->set(compact('featureUser'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $featureUser = $this->FeatureUser->newEmptyEntity();
        if ($this->request->is('post')) {
            $featureUser = $this->FeatureUser->patchEntity($featureUser, $this->request->getData());
            if ($this->FeatureUser->save($featureUser)) {
                $this->Flash->success(__('The feature user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feature user could not be saved. Please, try again.'));
        }
        $user = $this->FeatureUser->User->find('list', ['limit' => 200])->all();
        $feature = $this->FeatureUser->Feature->find('list', ['limit' => 200])->all();
        $this->set(compact('featureUser', 'user', 'feature'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feature User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $featureUser = $this->FeatureUser->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $featureUser = $this->FeatureUser->patchEntity($featureUser, $this->request->getData());
            if ($this->FeatureUser->save($featureUser)) {
                $this->Flash->success(__('The feature user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The feature user could not be saved. Please, try again.'));
        }
        $user = $this->FeatureUser->User->find('list', ['limit' => 200])->all();
        $feature = $this->FeatureUser->Feature->find('list', ['limit' => 200])->all();
        $this->set(compact('featureUser', 'user', 'feature'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feature User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $featureUser = $this->FeatureUser->get($id);
        if ($this->FeatureUser->delete($featureUser)) {
            $this->Flash->success(__('The feature user has been deleted.'));
        } else {
            $this->Flash->error(__('The feature user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
