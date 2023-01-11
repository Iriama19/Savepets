<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\EventTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\EventTable Test Case
 */
class EventTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\EventTable
     */
    protected $Event;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Event',
        'app.User',
        'app.Address'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Event') ? [] : ['className' => EventTable::class];
        $this->Event = $this->getTableLocator()->get('Event', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Event);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\EventTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $hasErrors=$event->hasErrors();
        $this->assertFalse($hasErrors);        
    }

    //Título
    public function testValidationTitleRequired(): void
    {
     
        $event = $this->Event->newEntity([
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "El campo título es requerido.";
        $this->assertTrue($expected==$error["title"]["_required"]);
    }
    public function testValidationTitleRegex(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'vdvd&vdvd',
            'message' => 'Lorem ipsum dolor sit$%$ amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["title"]["regex"]==$expected);
    }
    public function testValidationTitleEmpty(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => '',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "El título no puede ser vacío.";
        $this->assertTrue($expected==$error["title"]["_empty"]);
    }


    public function testValidationTitleMin(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'a',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1]);

        $error = $event->getErrors();
        $expected = "El título debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["title"]["minLength"]);
    }

    public function testValidationTitleMax(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1]);

        $error = $event->getErrors();
        $expected = "El título debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["title"]["maxLength"]);
    }

    //Mensaje
    public function testValidationMessageMax(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'aaaaaaa',
            'message' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1]);

        $error = $event->getErrors();
        $expected = "El mensaje debe tener máximo 300 caracteres.";
        $this->assertTrue($expected==$error["message"]["maxLength"]);
    }

    public function testValidationMessageRegex(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'svdsvd',
            'message' => 'Lorem ip$%$sum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "El mensaje debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["message"]["regex"]==$expected);
    }
    //Start_date
    public function testValidationStartDateRequired(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);
        $error = $event->getErrors();
        $expected = "El campo fecha de inicio es requerido.";
        $this->assertTrue($expected==$error["start_date"]["_required"]);
    }

    public function testValidationStartDateEmpty(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de inicio no puede ser vacía.";
        $this->assertTrue($expected==$error["start_date"]["_empty"]);
    }

    public function testValidationStartDateDateTime(): void
    {
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de inicio introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["start_date"]["dateTime"]);
    }


    public function testValidationStartDateBetweenValid(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '1980-11-10 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de inicio debe ser entre 1990 y 2050.";
        $this->assertTrue($error["start_date"]["custom"]==$expected);
    }
    //End-date
    public function testValidationEndDateRequired(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);
        $error = $event->getErrors();
        $expected = "El campo fecha de fin es requerido.";
        $this->assertTrue($expected==$error["end_date"]["_required"]);
    }

    public function testValidationEndDateEmpty(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de fin no puede ser vacía.";
        $this->assertTrue($expected==$error["end_date"]["_empty"]);
    }

    public function testValidationEndDateDateTime(): void
    {
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de fin introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["end_date"]["dateTime"]);
    }


    public function testValidationEndDateBetweenValid(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2051-11-10 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de fin debe ser entre 1990 y 2050.";
        $this->assertTrue($error["end_date"]["custom"]==$expected);
    }


    public function testValidationEndLatterValid(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2021-11-10 16:35:38',
            'user_id' => 1,
            'addres_id' => 1
        ]);

        $error = $event->getErrors();
        $expected = "La fecha de fin tiene que ser más tarde que la de inicio.";
        $this->assertTrue($error["end_date"]["endlatter"]==$expected);
    }

    //User_id
    public function testValidationUserIDInteger(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 'ef',
            'addres_id' => 1]);

        $error = $event->getErrors();
        $expected = "El id del usuario debe ser un número entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }


    //Address-id 
    public function testValidationAddressIDInteger(): void
    {
     
        $event = $this->Event->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'message' => 'Lorem ipsum dolor sit amet',
            'start_date' => '2022-11-12 16:35:38',
            'end_date' => '2022-11-12 16:35:38',
            'user_id' => 1,
            'addres_id' => 'pp']);

        $error = $event->getErrors();
        $expected = "El id de la dirección debe ser un número entero.";
        $this->assertTrue($expected==$error["addres_id"]["integer"]);
    }

}
