<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AnimalAdoptionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\AnimalAdoptionController Test Case
 *
 * @uses \App\Controller\AnimalAdoptionController
 */
class AnimalAdoptionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AnimalAdoption',
        'app.User',
        'app.Animal',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::index()
     */
    public function testIndex(): void
    {
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('/animal-adoption');
        $this->assertResponseOk();    
    }

    public function testBuscar(): void
    {
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('/animal-adoption?keyAnimal=Lorem&keyUsuario=');
        $this->assertResponseOk();
    }


    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/index');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::view()
     */
    public function testView(): void
    {
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('animal-adoption/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem');    
    }

    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/animal-adoption/view/1');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::add()
     */
    public function testAdd(): void
    {
        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('animal-adoption/add');

        $this->assertResponseOk();

        $data=[
            'start_date' => '2022-11-02 20:45:51',
            'end_date' => '2022-11-03 20:00:51',
            'user_id' => 1,
            'animal_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('animal-adoption/add',$data);
        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);

        $animaladoption = TableRegistry::get('AnimalAdoption');

        $query = $animaladoption->find()->where(['end_date' => $data['end_date']]);

        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/add');
        $this->assertRedirectContains('/user/login');

    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::edit()
     */
    public function testEdit(): void
    {

        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('animal-adoption/edit/1');

        $this->assertResponseOk();

        $data=[

            'start_date' => '2022-11-02 20:45:51',
            'end_date' => '2023-11-04 09:48:38',
            'user_id' => 1,
            'animal_id' => 1
        ];
        $this->enableCsrfToken();
        $this->post('animal-adoption/edit/1',$data);
        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);

        $animaladoption = TableRegistry::get('AnimalAdoption');

        $query = $animaladoption->find()->where(['end_date' => $data['end_date']]);

        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal-adoption/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalAdoptionController::delete()
     */
    public function testDelete(): void
    {

        $this->session([
            'Auth' => [
                    'id' => 1,
                    'DNI_CIF' => '22175395Z',
                    'name' => 'Prueba',
                    'lastname' => 'Prueba Prueba',
                    'username' => 'Pruebatesting',
                    'password' => 'prueba',
                    'email' => 'prueba@gmail.com',
                    'phone' => '639087621',
                    'birth_date' => '1999-12-14',
                    'role' => 'admin',
                    'addres_id' => 1
            ]
        ]);
        $this->enableCsrfToken();
        $this->post('/animal-adoption/delete/1');

        $this->assertRedirect(['controller' => 'AnimalAdoption', 'action' => 'index']);

        $animaladoption = TableRegistry::get('AnimalAdoption');
        $data = $animaladoption->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());
     }

     public function testDeleteUnauthenticatedFail(): void
     {
         $this->enableCsrfToken();
         $this->delete('/animal-adoption/delete/1');
         $this->assertRedirectContains('/user/login');
 
     }
 }
