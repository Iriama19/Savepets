<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\EventController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\EventController Test Case
 *
 * @uses \App\Controller\EventController
 */
class EventControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Event',
        'app.User',
        'app.Address'
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\EventController::index()
     */
    public function testIndex(): void
    {
        $this->get('/event');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\EventController::view()
     */
    public function testView(): void
    {

        $this->get('event/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem');
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\EventController::add()
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
        $this->get('event/add');

        $this->assertResponseOk();

        $data=[
            'title' => 'EventAdd',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-13 16:35:38',
            'user_id' => 1,
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'eventLoremmmmadd',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]        
        ];
        $this->enableCsrfToken();
        $this->post('event/add',$data);
        $this->assertRedirect(['controller' => 'Event', 'action' => 'index']);

        $event = TableRegistry::get('Event');
        $query = $event->find()->where(['title' => $data['title']]);
        $this->assertEquals(1,$query->count());    

        $addres = TableRegistry::get('Address');

        $query = $addres->find()->where(['country' => $data['addres']['country']]);

        $this->assertEquals(1,$query->count());
    }

     public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('event/add');
        $this->assertRedirectContains('/user/login');
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\EventController::edit()
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
        $this->get('event/edit/1');

        $this->assertResponseOk();

        $data=[
            'title' => 'Lorem EventEdit',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres' => [
                'province' => 'Pontevedra',
                'postal_code' => 35004,
                'country' => 'Lorem',
                'city' => 'LoremoEdit',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('event/edit/1',$data);
        $this->assertRedirect(['controller' => 'Event', 'action' => 'index']);

        $addres = TableRegistry::get('Event');

        $query = $addres->find()->where(['title' => $data['title']]);

        $this->assertEquals(1,$query->count());

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['city' => $data['addres']['city']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('event/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\EventController::delete()
     */
    public function testDelete(): void
    {
        $event = TableRegistry::get('Event');

        $eventAddrestoDelete = $event->find()->where(['id' => 1])->select('addres_id')->first();

        $addrestoDeleteID=$eventAddrestoDelete['addres_id'];
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
        $this->post('/address/delete/'.$addrestoDeleteID.'/Event'.'/'.NULL);
        $this->assertRedirect(['controller' => 'Event', 'action' => 'index']);

        $data = $event->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $addres = TableRegistry::get('Address');

        $data = $addres->find()->where(['id' => $addrestoDeleteID]);
        $this->assertEquals(0,$data->count());
        
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/event/delete/1/Event');
        $this->assertRedirectContains('/user/login');

    }
 }
