<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FosterListController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\FosterListController Test Case
 *
 * @uses \App\Controller\FosterListController
 */
class FosterListControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterList',
        'app.User',
        'app.FosterListUser',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FosterListController::index()
     */
    public function testIndex(): void
    {
        $this->get('/foster-list');
        $this->assertResponseOk();    
    }

    public function testBuscar(): void
    {
        $this->get('/foster-list?keyCiudad=a&keyProvincia=&keyPais=');
        $this->assertResponseOk();
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FosterListController::add()
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
        $this->get('foster-list/add');

        $this->assertResponseOk();

        $data=[
            'user_id' => 2
        ];
        $this->enableCsrfToken();
        $this->post('foster-list/add',$data);
        $this->assertRedirect(['controller' => 'FosterList', 'action' => 'index']);

        $fosterlist = TableRegistry::get('FosterList');

        $query = $fosterlist->find()->where(['user_id' => $data['user_id']]);

        $this->assertEquals(1,$query->count());

    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('foster-list/add');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FosterListController::delete()
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
        $this->post('/foster-list/delete/1');

        $this->assertRedirect(['controller' => 'FosterList', 'action' => 'index']);

        $fosterlist = TableRegistry::get('FosterList');
        $data = $fosterlist->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/foster-list/delete/1');
        $this->assertRedirectContains('/user/login');

    }
}
