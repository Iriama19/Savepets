<?php
declare(strict_types=1);

namespace App\Test\TestCase\Controller;

use App\Controller\PublicationStrayAddressController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;
use Cake\ORM\TableRegistry;

/**
 * App\Controller\PublicationStrayAddressController Test Case
 *
 * @uses \App\Controller\PublicationStrayAddressController
 */
class PublicationStrayAddressControllerTest extends TestCase
{
    use IntegrationTestTrait;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStrayAddress',
        'app.PublicationStray',
        'app.Publication',
        'app.Address',
        'app.User',
    ];

    /**
     * Test index method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::index()
     */
    public function testIndex(): void
    {
        $this->get('/publication-stray-address/index/1');
        $this->assertResponseOk();       
    }

    /**
     * Test view method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::view()
     */
    public function testView(): void
    {
        $this->get('publication-stray-address/view/1');
        $this->assertResponseOk();
        $this->assertResponseContains('Pontevedra'); 
    }
    /**
     * Test add method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::add()
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
        $this->get('publication-stray-address/add/1');

        $this->assertResponseOk();

        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:24:05',
            'image' => '',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmaddstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/add/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');
        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);
        $this->assertEquals(1,$query->count());

        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());
    }

    public function testAddUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray-address/add/1');
        $this->assertRedirectContains('/user/login');

    }

    /**
     * Test edit method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::edit()
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
        $this->get('publication-stray-address/edit/1');

        $this->assertResponseOk();
        $data=[
            'publication_stray_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-12-12 11:44:09',
            'image' => '',
            'addres' => [
                'province' => 'Ourense',
                'postal_code' => 35004,
                'country' => 'Loremmmmeditstray',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ]
        ];
        $this->enableCsrfToken();
        $this->post('publication-stray-address/edit/1',$data);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 1,'action' => 'index']);

        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');

        $query = $publicationstrayaddress->find()->where(['publication_date' => $data['publication_date']]);

        $this->assertEquals(1,$query->count());


        $addres = TableRegistry::get('Address');
        $query = $addres->find()->where(['country' => $data['addres']['country']]);
        $this->assertEquals(1,$query->count());
    }

    public function testEditUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->get('publication-stray-address/edit/1');
        $this->assertRedirectContains('/user/login');

    }


    /**
     * Test delete method
     *
     * @return void
     * @uses \App\Controller\PublicationStrayAddressController::delete()
     */
    public function testDelete(): void
    {
        $publicationstrayaddress = TableRegistry::get('PublicationStrayAddress');

        $publicationstrayaddresstoDelete = $publicationstrayaddress->find()->where(['id' => 1])->select('addres_id')->first();
        $publicationstrayaddresstoDeleteID=$publicationstrayaddresstoDelete['addres_id'];

        $publicationstraypublicationtoDelete = $publicationstrayaddress->find()->where(['id' => 1])->select('publication_stray_id')->first();
        $publicationstraypublicationtoDeleteID=$publicationstraypublicationtoDelete['publication_stray_id'];

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
        $this->post('/address/delete/1/PublicationStrayAddress'.'/'.$publicationstraypublicationtoDeleteID);
        $this->assertRedirect(['controller' => 'PublicationStrayAddress', 'action' => 'index',$publicationstraypublicationtoDeleteID]);

        $data = $publicationstrayaddress->find()->where(['id' => 1]);
        $this->assertEquals(0,$data->count());

        $addres = TableRegistry::get('Address');

        $data = $addres->find()->where(['id' => $publicationstrayaddresstoDeleteID]);
        $this->assertEquals(0,$data->count());

        $publicationstray = TableRegistry::get('PublicationStray');

        $data = $publicationstray->find()->where(['id' => $publicationstraypublicationtoDeleteID]);
        $this->assertEquals(0,$data->count());
    }

    public function testDeleteUnauthenticatedFail(): void
    {
        $this->enableCsrfToken();
        $this->delete('/publication-stray-address/delete/1');
        $this->assertRedirectContains('/user/login');

    }
}
