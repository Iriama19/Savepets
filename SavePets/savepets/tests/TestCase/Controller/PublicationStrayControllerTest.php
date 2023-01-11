<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationStrayController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationStrayController Test Case
 *
 * @uses \App\Controller\PublicationStrayController
 */
class PublicationStrayControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStray',
        'app.Address',
        'app.PublicationStrayAddress',
        'app.Publication',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::index()
     */
    public function testIndex(): void
    {
        $this->get('/publication-stray');
        $this->assertResponseOk(); 
    }

    public function testBuscar(): void
    {
        $this->get('/publication-stray?keyUrgente=yes&keyCiudad=&keyProvincia=Pontevedra&keyPais=');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::view()
     */
    public function testView(): void
    {
        $this->get('publication-stray/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('no'); 
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::add()
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
                    'birth_date' => '1999-12-14',

                    'role' => 'admin',
                    'addres_id' => 1
                
            ]
        ]);
        $this->get('publication-stray/add');

        $this->assertResponseOk();

        $data=[
            'image' => '',
            'urgent' => 'yes',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionStrayAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/add',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);

        $publicationstray = TableRegistry::get('PublicationStray');

        $query = $publicationstray->find()->where(['urgent' => $data['urgent']]);

        $this->assertEquals(1,$query->count());


        $publication = TableRegistry::get('Publication');

        $query = $publication->find()->where(['title' => $data['publication']['title']]);

        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray/add');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::edit()
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
        $this->get('publication-stray/edit/1');
        $this->assertResponseOk();

        $data=[
            'image' => '',
            'urgent' => 'yes',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);

        $publicationstray = TableRegistry::get('PublicationStray');

        $query = $publicationstray->find()->where(['user_id' => $data['user_id']]);

        $this->assertEquals(1,$query->count());

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayController::delete()
     */
  
    public function testDelete(): void
    {
        $publicationstray = TableRegistry::get('PublicationStray');

        $publicationtoDelete = $publicationstray->find()->where(['publication_id' => 1])->select('publication_id')->first();

        $publicationtoDeleteID=$publicationtoDelete['publication_id'];
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
        $this->post('/publication/delete/'.$publicationtoDeleteID.'/Stray');
        $this->assertRedirect(['controller' => 'PublicationStray', 'action' => 'index']);

        $data = $publicationstray->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());

        
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication/delete/1/Stray');
        $this->assertRedirectContains('/user/login');

    }
}
