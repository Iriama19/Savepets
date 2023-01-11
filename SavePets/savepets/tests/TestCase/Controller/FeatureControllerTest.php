<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\FeatureController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\ORM\TableRegistry;

use Cake\TestSuite\TestCase;

/**
 * App\Controller\FeatureController Test Case
 *
 * @uses \App\Controller\FeatureController
 */
class FeatureControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Feature',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\FeatureController::index()
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
        $this->get('/feature');
        $this->assertResponseOk();
    }
    public function testIndexUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('feature/index');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\FeatureController::add()
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
        $this->get('feature/add');

        $this->assertResponseOk();

        $data=[
            'key_feature' => 'bbbb',
        ];
        $this->enableCsrfToken();
        $this->post('feature/add', $data);
        $this->assertRedirect(['controller' => 'Feature', 'action' => 'index']);

        $user = TableRegistry::get('Feature');
        $query = $user->find()->where(['key_feature' => $data['key_feature']]);
        $this->assertEquals(1,$query->count());
    }
    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('feature/add');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\FeatureController::edit()
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
        $this->get('feature/edit/1');

        $this->assertResponseOk();
        $data=[
            'key_feature' => 'cccc',
        ];
        $this->enableCsrfToken();
        $this->post('feature/edit/1',$data);
        $this->assertRedirect(['controller' => 'Feature', 'action' => 'index']);

        $user = TableRegistry::get('Feature');
        $query = $user->find()->where(['key_feature' => $data['key_feature']]);
        $this->assertEquals(1,$query->count());
    }
    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('feature/edit/1');
        $this->assertRedirectContains('/user/login');

    }
    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\FeatureController::delete()
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
        $this->post('/feature/delete/1');

        $this->assertRedirect(['controller' => 'Feature', 'action' => 'index']);

        $feature = TableRegistry::get('Feature');
        $data = $feature->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());


    }


    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/feature/delete/1');
        $this->assertRedirectContains('/user/login');

    }
}
