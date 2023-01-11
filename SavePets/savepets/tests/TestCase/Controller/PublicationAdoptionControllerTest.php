<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationAdoptionController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationAdoptionController Test Case
 *
 * @uses \App\Controller\PublicationAdoptionController
 */
class PublicationAdoptionControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationAdoption',
        'app.Publication',
        'app.Animal',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::index()
     */
    public function testIndex(): void
    {
        $this->get('/publication-adoption');
        $this->assertResponseOk();       
    }

    public function testBuscar(): void
    {
        $this->get('/publication-adoption?keyUrgente=yes');
        $this->assertResponseOk();
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::view()
     */
    public function testView(): void
    {
        $this->get('publication-adoption/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('yes');     }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::add()
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
        $this->get('publication-adoption/add');

        $this->assertResponseOk();

        $data=[
            'animal_id' => 1,
            'urgent' => 'no',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdopAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-adoption/add',$data);
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);

        $publicationadoption = TableRegistry::get('PublicationAdoption');

        $query = $publicationadoption->find()->where(['urgent' => $data['urgent']]);

        $this->assertEquals(1,$query->count());


        $publication = TableRegistry::get('Publication');

        $query = $publication->find()->where(['title' => $data['publication']['title']]);

        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-adoption/add');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::edit()
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
        $this->get('publication-adoption/edit/1');

        $this->assertResponseOk();

        $data=[
            'animal_id' => 1,
            'urgent' => 'no',
            'user_id' => 2,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdopEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-adoption/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);

        $publicationadoption = TableRegistry::get('PublicationAdoption');

        $query = $publicationadoption->find()->where(['user_id' => $data['user_id']]);

        $this->assertEquals(1,$query->count());

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-adoption/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationAdoptionController::delete()
     */

    public function testDelete(): void
    {
        $publicationadoption = TableRegistry::get('PublicationAdoption');

        $publicationtoDelete = $publicationadoption->find()->where(['publication_id' => 1])->select('publication_id')->first();

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
        $this->post('/publication/delete/'.$publicationtoDeleteID.'/Adoption');
        $this->assertRedirect(['controller' => 'PublicationAdoption', 'action' => 'index']);

        $data = $publicationadoption->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());

        
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication/delete/1/Adoption');
        $this->assertRedirectContains('/user/login');

    }
}
