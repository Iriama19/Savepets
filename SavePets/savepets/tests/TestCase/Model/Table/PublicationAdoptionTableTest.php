<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicationAdoptionTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicationAdoptionTable Test Case
 */
class PublicationAdoptionTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicationAdoptionTable
     */
    protected $PublicationAdoption;

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
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicationAdoption') ? [] : ['className' => PublicationAdoptionTable::class];
        $this->PublicationAdoption = $this->getTableLocator()->get('PublicationAdoption', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicationAdoption);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicationAdoptionTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 1,
            'animal_id' => 1,
            'urgent' => 'yes',
            'user_id' => 1
        ]);

        $hasErrors=$publicationadoption->hasErrors();
        $this->assertFalse($hasErrors);    
    }


    //Publication_id
    public function testValidationPublicationIDInteger(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 'pe',
            'animal_id' => 1,
            'urgent' => 'yes',
            'user_id' => 1
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "El índice de la publicación debe ser un entero.";
        $this->assertTrue($expected==$error["publication_id"]["integer"]);
    }

    //Animal_id
    public function testValidationAnimalIDInteger(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 1,
            'animal_id' => 'pe',
            'urgent' => 'yes',
            'user_id' => 1
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "El índice del animal debe ser un entero.";
        $this->assertTrue($expected==$error["animal_id"]["integer"]);
    }    

    //Urgente

    public function testValidationUrgenteEmpty(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 1,
            'animal_id' => 1,
            'urgent' => '',
            'user_id' => 1
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "Urgente no puede ser vacía.";
        $this->assertTrue($expected==$error["urgent"]["_empty"]);
    }

    public function testValidationUrgenteRequired(): void
    {
     
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 1,
            'animal_id' => 1,
            'user_id' => 1
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "El campo urgente es requerido.";
        $this->assertTrue($expected==$error["urgent"]["_required"]);
    }

    public function testValidationUrgenteInlist(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([
            'publication_id' => 1,
            'animal_id' => 1,
            'urgent' => 'yess',
            'user_id' => 1
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "Urgente debe ser sí o no.";
        $this->assertTrue($expected==$error["urgent"]["inList"]);
    }

    //User_id
    public function testValidationUserIDInteger(): void
    {
        $publicationadoption = $this->PublicationAdoption->newEntity([

            'publication_id' => 1,
            'animal_id' => 1,
            'urgent' => 'yes',
            'user_id' => 'pe'
        ]);
        $error = $publicationadoption->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }

}
