<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\AnimalController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;
/**
 * App\Controller\AnimalController Test Case
 *
 * @uses \App\Controller\AnimalController
 */
class AnimalControllerTest extends TestCase
{
    use IntegrationTestTrait;
    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Animal',
        'app.AnimalShelter',
        'app.User',
        'app.Message',

    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\AnimalController::index()
     */
    public function testIndex(): void
    {
        $this->get('/animal');
        $this->assertResponseOk();
    }

    public function testBuscar(): void
    {
        $this->get('/animal?keyEspecie=dog&keyRaza=&keySexo=');
        $this->assertResponseOk();
    }


    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\AnimalController::view()
     */
    public function testView(): void
    {
        $this->get('animal/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\AnimalController::add()
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
        $this->get('animal/add');

        $this->assertResponseOk();

        $data=[
            'name' => 'AñadirAnimal',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-05-03 10:47:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/add',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);

        $animal = TableRegistry::get('Animal');

        $query = $animal->find()->where(['name' => $data['name']]);

        $this->assertEquals(1,$query->count());


        $animalshelter = TableRegistry::get('AnimalShelter');

        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);

        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal/add');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\AnimalController::edit()
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
        $this->get('animal/edit/1');

        $this->assertResponseOk();

        $data=[
            'name' => 'EditAnimal',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es un animal.',
            'state' => 'sick',
            'animal_shelter' => [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2023-11-03 11:48:38',
                'user_id' => 1,
                'animal_id' => 1
            ]
        ];
        $this->enableCsrfToken();
        $this->post('animal/edit/1',$data);
        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);

        $animal = TableRegistry::get('Animal');

        $query = $animal->find()->where(['name' => $data['name']]);

        $this->assertEquals(1,$query->count());

        $animalshelter = TableRegistry::get('AnimalShelter');
        $query = $animalshelter->find()->where(['end_date' => $data['animal_shelter']['end_date']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('animal/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\AnimalController::delete()
     */
    public function testDelete(): void
    {
        $animalshelter = TableRegistry::get('AnimalShelter');

        $animalsheltertoDelete = $animalshelter->find()->where(['animal_id' => 1])->select('id')->first();
        $animalsheltertoDeleteID=$animalsheltertoDelete['id'];
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
        $this->post('/animal/delete/1');

        $this->assertRedirect(['controller' => 'Animal', 'action' => 'index']);

        $animal = TableRegistry::get('Animal');
        $data = $animal->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $data = $animalshelter->find()->where(['id' => $animalsheltertoDeleteID]);
        $this->assertEquals(0,$data->count());
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/animal/delete/1');
        $this->assertRedirectContains('/user/login');

    }
 }
