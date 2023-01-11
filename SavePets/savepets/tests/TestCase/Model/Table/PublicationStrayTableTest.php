<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicationStrayTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicationStrayTable Test Case
 */
class PublicationStrayTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicationStrayTable
     */
    protected $PublicationStray;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.PublicationStray',
        'app.Publication',
        'app.User'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicationStray') ? [] : ['className' => PublicationStrayTable::class];
        $this->PublicationStray = $this->getTableLocator()->get('PublicationStray', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicationStray);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicationStrayTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $publicationstray = $this->PublicationStray->newEntity([
            'publication_id' => 1,
            'urgent' => 'yes',
            'image' => '',
            'user_id' => 1
        ]);

        $hasErrors=$publicationstray->hasErrors();
        $this->assertFalse($hasErrors);    
    }


    //Publication_id
    public function testValidationPublicationIDInteger(): void
    {
        $publicationstray = $this->PublicationStray->newEntity([
            'publication_id' => 'pe',
            'urgent' => 'yes',
            'image' => '',
            'user_id' => 1
        ]);
        $error = $publicationstray->getErrors();
        $expected = "El índice de la publicación debe ser un entero.";
        $this->assertTrue($expected==$error["publication_id"]["integer"]);
    }  
    //Urgente

    public function testValidationUrgenteEmpty(): void
    {
        $publicationstray = $this->PublicationStray->newEntity([
            'publication_id' => 1,
            'urgent' => '',
            'image' => '',
            'user_id' => 1
        ]);
        $error = $publicationstray->getErrors();
        $expected = "Urgente no puede ser vacío.";
        $this->assertTrue($expected==$error["urgent"]["_empty"]);
    }

    public function testValidationUrgenteRequired(): void
    {
     
        $publicationstray = $this->PublicationStray->newEntity([
            'publication_id' => 1,
            'image' => '',
            'user_id' => 1
        ]);
        $error = $publicationstray->getErrors();
        $expected = "El campo urgente es requerido.";
        $this->assertTrue($expected==$error["urgent"]["_required"]);
    }

    public function testValidationUrgenteInlist(): void
    {
        $publicationstray = $this->PublicationStray->newEntity([
            'publication_id' => 1,
            'image' => '',
            'urgent' => 'yess',
            'user_id' => 1
        ]);
        $error = $publicationstray->getErrors();
        $expected = "Urgente debe ser sí o no.";
        $this->assertTrue($expected==$error["urgent"]["inList"]);
    }

    //User_id
    public function testValidationUserIDInteger(): void
    {
        $publicationstray = $this->PublicationStray->newEntity([

            'publication_id' => 1,
            'image' => '',
            'urgent' => 'yes',
            'user_id' => 'pe'
        ]);
        $error = $publicationstray->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }

}