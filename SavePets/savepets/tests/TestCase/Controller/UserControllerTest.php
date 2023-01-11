<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\UserController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\UserController Test Case
 *
 * @uses \App\Controller\UserController
 */
class UserControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.User',
        'app.Address',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\UserController::index()
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
        $this->get('/user');
        $this->assertResponseOk();
    }


    public function testBuscar(): void
    {
        $this->get('/user?key=&keyRole=admin');
        $this->assertResponseOk();
    }

    // /**
    //  * Test view method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::view()
    //  */
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
        $this->get('user/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('22175395Z');
    }

    public function testViewUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('user/view/1');
        $this->assertRedirectContains('/user/login');

    }
    // /**
    //  * Test add method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::add()
    //  */
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
        $this->get('user/add');

        $this->assertResponseOk();

        $data=[
            'DNI_CIF' => '35728482Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouser@gmail.com',
            'phone' => '639087691',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremadd',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/add', $data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'index']);

        $user = TableRegistry::get('User');
        $query = $user->find()->where(['DNI_CIF' => $data['DNI_CIF']]);
        $this->assertEquals(1,$query->count());

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());
    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\UserController::edit()
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
                    'birth_date' => '1999-12-14',
                    'phone' => '639087621',
                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('user/edit/1');

        $this->assertResponseOk();
        $data=[
            'DNI_CIF' => '35728482Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouseredit@gmail.com',
            'phone' => '639087691',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmedit',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/edit/1',$data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'index']);

        $user = TableRegistry::get('User');
        $query = $user->find()->where(['email' => $data['email']]);
        $this->assertEquals(1,$query->count());

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('user/edit/1');
        $this->assertRedirectContains('/user/login');

    }
    // /**
    //  * Test login method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::login()
    //  */
    public function testLogin(): void
    {
        //Añado un usuario 
        $data=[
            'DNI_CIF' => '94802477L',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Nuevouser',
            'password' => 'prueba',
            'email' => 'nuevouserlog@gmail.com',
            'phone' => '639087771',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremadd',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('user/add', $data);
        $this->assertRedirect(['controller' => 'User', 'action' => 'index']);

        $user = TableRegistry::get('User'); //Compruebo que efectivamente ese usuario existe
        $query = $user->find()->where(['DNI_CIF' => '94802477L']);
        $this->assertEquals(1,$query->count());

        //Logeo
        $this->enableSecurityToken();
        $this->enableCsrfToken();

        $this->get('/user/login');
        $this->assertResponseOk();

        $this->post('/user/login', [
            'DNI_CIF' => '94802477L',
            'password' => 'prueba' ]
        );
        $this->assertResponseCode(302); //Si correcto redirige
        $this->assertSession(3,'Auth.id');
    }
    // /**
    //  * Test logout method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::logout()
    //  */
    public function testLogout(): void
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
        $this->post('/user/logout');
        $this->assertSession(null, 'Auth.id');
        $this->assertRedirect(['controller' => 'User', 'action' => 'login']);

    }

    // /**
    //  * Test delete method
    //  *
    //  * @return void
    //  * @uses \App\Controller\UserController::delete()
    //  */
    public function testDelete(): void
    {
        $user = TableRegistry::get('User');

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
        $this->post('/user/delete/1');
        $user = TableRegistry::get('User');
        $data = $user->find()->where(['username' => 'Anonimo1']);
        $this->assertEquals(1,$data->count());

    }


    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/user/delete/1');
        $this->assertRedirectContains('/user/login');

    }

}
