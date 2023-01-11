<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicationTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicationTable Test Case
 */
class PublicationTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicationTable
     */
    protected $Publication;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Publication',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Publication') ? [] : ['className' => PublicationTable::class];
        $this->Publication = $this->getTableLocator()->get('Publication', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Publication);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicationTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $hasErrors=$publicacion->hasErrors();
        $this->assertFalse($hasErrors);      
    }

    // Fecha publicación
    public function testValidationPublicationDateRequired(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "El campo fecha de publicación es requerido.";
        $this->assertTrue($expected==$error["publication_date"]["_required"]);
    }

    public function testValidationPublicationDateEmpty(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "La fecha no puede ser vacía.";
        $this->assertTrue($expected==$error["publication_date"]["_empty"]);
    }

    public function testValidationPublicationDateTime(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["publication_date"]["dateTime"]);
    }

    public function testValidationEndDateBetweenValid(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2051-11 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "La fecha debe ser entre 2022 y 2050.";
        $this->assertTrue($error["publication_date"]["custom"]==$expected);
    }


    //Title
    public function testValidationTitleEmpty(): void
    {
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => '',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "El título no puede ser vacío.";
        $this->assertTrue($expected==$error["title"]["_empty"]);
    }

    public function testValidationTitleRequired(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $publicacion->getErrors();
        $expected = "El campo título es requerido.";
        $this->assertTrue($expected==$error["title"]["_required"]);
    }
    public function testValidationTitleRegex(): void
    {
     

        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Loee$',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);
        $error = $publicacion->getErrors();
        $expected = "El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["title"]["regex"]==$expected);
    }
    public function testValidationTitleMin(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lo',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);
        $error = $publicacion->getErrors();
        $expected = "El título debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["title"]["minLength"]);
    }

    public function testValidationTitleMax(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'message' => 'Lorem ipsum dolor sit amet'
        ]);        
        $error = $publicacion->getErrors();
        $expected = "El título debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["title"]["maxLength"]);
    }


    //Mensaje
    public function testValidationMessageEmpty(): void
    {
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => ''
        ]);

        $error = $publicacion->getErrors();
        $expected = "El mensaje no puede ser vacío.";
        $this->assertTrue($expected==$error["message"]["_empty"]);
    }

    public function testValidationMessageRequired(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
        ]);

        $error = $publicacion->getErrors();
        $expected = "El campo mensaje es requerido.";
        $this->assertTrue($expected==$error["message"]["_required"]);
    }

    public function testValidationMessageMin(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'L'
        ]);
        $error = $publicacion->getErrors();
        $expected = "El mensaje debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["message"]["minLength"]);
    }

    public function testValidationMessageMax(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit ametaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ]);        
        $error = $publicacion->getErrors();
        $expected = "El mensaje debe tener máximo 700 caracteres.";
        $this->assertTrue($expected==$error["message"]["maxLength"]);
    }

    public function testValidationMessageRegex(): void
    {
     
        $publicacion = $this->Publication->newEntity([
            'publication_date' => '2022-11-05 21:59:41',
            'title' => 'Loee',
            'message' => 'Lorem$ ipsum dolor sit amet'
        ]);
        $error = $publicacion->getErrors();
        $expected = "El mensaje debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["message"]["regex"]==$expected);
    }
}
