<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FosterListUserController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FosterListUserController Test Case
 *
 * @uses \App\Controller\FosterListUserController
 */
class FosterListUserControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterListUser',
        'app.FosterList',
        'app.User'
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::index()
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
    
        $this->get('/foster-list-user');
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('/foster-list-user?keyEspecie=a');
        $this->assertResponseOk();
    }

    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/foster-list-user');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::view()
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);

        $this->get('foster-list-user/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('cat');    
    }


    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('/foster-list-user/view/1');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::add()
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('foster-list-user/add/2');

        $this->assertResponseOk();

        $data=[
            'foster_list_id' => 1,
            'user_id' => 2,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 17:41:20'
        ];
        $this->enableCsrfToken();
        $this->post('foster-list-user/add/2',$data);
        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);

        $fosterlistuser = TableRegistry::get('FosterListUser');

        $query = $fosterlistuser->find()->where(['foster_date' => $data['foster_date']]);

        $this->assertEquals(1,$query->count());

    }
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list-user/add');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::edit()
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
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('foster-list-user/edit/1');

        $this->assertResponseOk();

        $data=[
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 19:41:20'
        ];
        $this->enableCsrfToken();
        $this->post('foster-list-user/edit/1',$data);
        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);

        $fosterlistuser = TableRegistry::get('FosterListUser');

        $query = $fosterlistuser->find()->where(['foster_date' => $data['foster_date']]);

        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list-user/edit/1');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListUserController::delete()
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
                    'role' => 'admin',
                    'addres_id' => 1
            ]
        ]);
        $this->enableCsrfToken();
        $this->post('/foster-list-user/delete/1');

        $this->assertRedirect(['controller' => 'FosterListUser', 'action' => 'index']);

        $fosterlistuser = TableRegistry::get('FosterListUser');
        $data = $fosterlistuser->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/foster-list-user/delete/1');
        $this->assertRedirectContains('/user/login');

    }
}
