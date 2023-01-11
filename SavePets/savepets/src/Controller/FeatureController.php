<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Feature Controller
 *
 * @property \App\Model\Table\FeatureTable $Feature
 * @method \App\Model\Entity\Feature[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class FeatureController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $feature = $this->paginate($this->Feature);

        $this->set(compact('feature'));
    }

    /**
     * View method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    // public function view($id = null)
    // {
    //     $feature = $this->Feature->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set(compact('feature'));
    // }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $feature = $this->Feature->newEmptyEntity();
        if ($this->request->is('post')) {
            $feature = $this->Feature->patchEntity($feature, $this->request->getData());
            if ($this->Feature->save($feature)) {
                $this->Flash->success(__('Se ha añadido la característica.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La característica no se ha podido guardar, por favor intentalo de nuevo.'));
        }
        $this->set(compact('feature'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $feature = $this->Feature->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $feature = $this->Feature->patchEntity($feature, $this->request->getData());
            if ($this->Feature->save($feature)) {
                $this->Flash->success(__('La característica se ha editado con exito.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('La característica no se ha podido editado, por favor intentalo de nuevo.'));
        }
        $this->set(compact('feature'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Feature id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $feature = $this->Feature->get($id);
        if ($this->Feature->delete($feature)) {
            $this->Flash->success(__('La característica se ha eliminado con éxito.'));
        } else {
            $this->Flash->error(__('La característica no se ha podido borrar, por favor intentalo de nuevo.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
