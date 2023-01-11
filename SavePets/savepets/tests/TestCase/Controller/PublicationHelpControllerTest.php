<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationHelpController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationHelpController Test Case
 *
 * @uses \App\Controller\PublicationHelpController
 */
class PublicationHelpControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationHelp',
        'app.Publication',
        'app.User',
        'app.Comment',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::index()
     */
    public function testIndex(): void
    {
        $this->get('/publication-help');
        $this->assertResponseOk();    
    }

    public function testBuscar(): void
    {
        $this->get('/publication-help/?keyCategoria=Textile');
        $this->assertResponseOk();
    }
    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::view()
     */
    public function testView(): void
    {
        $this->get('publication-help/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('textile');    
    }

    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::add()
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
        $this->get('publication-help/add');

        $this->assertResponseOk();

        $data=[
            'categorie' => 'food',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionAdd',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-help/add',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);

        $publicationhelp = TableRegistry::get('PublicationHelp');

        $query = $publicationhelp->find()->where(['categorie' => $data['categorie']]);

        $this->assertEquals(1,$query->count());


        $publication = TableRegistry::get('Publication');

        $query = $publication->find()->where(['title' => $data['publication']['title']]);

        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-help/add');
        $this->assertRedirectContains('/user/login');

    }


    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::edit()
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
        $this->get('publication-help/edit/1');

        $this->assertResponseOk();

        $data=[
            'categorie' => 'other',
            'user_id' => 1,
            'publication' => [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'PublicacionEdit',
                'message' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-help/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);

        $publicationhelp = TableRegistry::get('PublicationHelp');

        $query = $publicationhelp->find()->where(['categorie' => $data['categorie']]);

        $this->assertEquals(1,$query->count());

        $publication = TableRegistry::get('Publication');
        $query = $publication->find()->where(['title' => $data['publication']['title']]);
        $this->assertEquals(1,$query->count());

    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-help/edit/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationHelpController::delete()
     */
    public function testDelete(): void
    {
        $publicationhelp = TableRegistry::get('PublicationHelp');

        $publicationtoDelete = $publicationhelp->find()->where(['publication_id' => 1])->select('publication_id')->first();

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
        $this->post('/publication/delete/'.$publicationtoDeleteID.'/Help');
        $this->assertRedirect(['controller' => 'PublicationHelp', 'action' => 'index']);

        $data = $publicationhelp->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $publication = TableRegistry::get('Publication');
        $data = $publication->find()->where(['id' => $publicationtoDeleteID]);
        $this->assertEquals(0,$data->count());

        
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication/delete/1/Help');
        $this->assertRedirectContains('/user/login');

    }
}
