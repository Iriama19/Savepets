<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\MessageController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\MessageController Test Case
 *
 * @uses \App\Controller\MessageController
 */
class MessageControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Message',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\MessageController::index()
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

        $this->get('/message');
        $this->assertResponseOk();    
    }


    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/message');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\MessageController::view()
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

        $this->get('message/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Lorem');    
    }

    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('message/view/1');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\MessageController::add()
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
        $this->get('message/add');

        $this->assertResponseOk();

        $data=[
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Loremmesageadd',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes'
        ];
        $this->enableCsrfToken();
        $this->post('message/add',$data);
        $this->assertRedirect(['controller' => 'Message', 'action' => 'index']);

        $message = TableRegistry::get('Message');

        $query = $message->find()->where(['title' => $data['title']]);

        $this->assertEquals(1,$query->count());

    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('message/add');
        $this->assertRedirectContains('/user/login');

    }

}
