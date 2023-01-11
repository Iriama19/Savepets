<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicationStrayAddressTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicationStrayAddressTable Test Case
 */
class PublicationStrayAddressTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicationStrayAddressTable
     */
    protected $PublicationStrayAddress;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStrayAddress',
        'app.PublicationStray',
        'app.Address',
        'app.User',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicationStrayAddress') ? [] : ['className' => PublicationStrayAddressTable::class];
        $this->PublicationStrayAddress = $this->getTableLocator()->get('PublicationStrayAddress', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicationStrayAddress);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicationStrayAddressTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-11-08 11:24:05',
            'image' => ''
        ]);

        $hasErrors=$publicationstrayaddress->hasErrors();
        $this->assertFalse($hasErrors);        
    }


    //Publication_id
    public function testValidationPublicationIDInteger(): void
    {
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 'e',
            'addres_id' => 1,
            'user_id' => 1,
            'publication_date' => '2022-11-08 11:24:05',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "El índice de la publicación debe ser un entero.";
        $this->assertTrue($expected==$error["publication_stray_id"]["integer"]);
    }  

    //Address_id
    public function testValidationAddresIDInteger(): void
    {
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 'p',
            'user_id' => 1,
            'publication_date' => '2022-11-08 11:24:05',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "El índice de la dirección debe ser un entero.";
        $this->assertTrue($expected==$error["addres_id"]["integer"]);
    }


    //User_id
    public function testValidationUserIDInteger(): void
    {
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 'p',
            'publication_date' => '2022-11-08 11:24:05',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }


    // Fecha publicación
    public function testValidationPublicationRequired(): void
    {
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 'p',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "La fecha de publicación es requerido.";
        $this->assertTrue($expected==$error["publication_date"]["_required"]);
    }

    public function testValidationPublicationEmpty(): void
    {
     
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 'p',
            'publication_date' => '',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "La fecha no puede ser vacía.";
        $this->assertTrue($expected==$error["publication_date"]["_empty"]);
    }

    public function testValidationPublicationDateTime(): void
    {
     
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 'p',
            'publication_date' => '2022-11 11:24:05',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["publication_date"]["dateTime"]);
    }


    public function testValidationEndDateBetweenValid(): void
    {
     
        $publicationstrayaddress = $this->PublicationStrayAddress->newEntity([
            'publication_stray_id' => 1,
            'addres_id' => 1,
            'user_id' => 'p',
            'publication_date' => '2021-11-10 11:24:05',
            'image' => ''
        ]);

        $error = $publicationstrayaddress->getErrors();
        $expected = "La fecha debe ser entre 2022 y 2050.";
        $this->assertTrue($error["publication_date"]["custom"]==$expected);
    }
}
