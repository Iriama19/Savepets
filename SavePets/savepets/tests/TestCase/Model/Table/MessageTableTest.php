<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MessageTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MessageTable Test Case
 */
class MessageTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MessageTable
     */
    protected $Message;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Message',
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
        $config = $this->getTableLocator()->exists('Message') ? [] : ['className' => MessageTable::class];
        $this->Message = $this->getTableLocator()->get('Message', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Message);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MessageTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $hasErrors=$message->hasErrors();
        $this->assertFalse($hasErrors);   
    }

    // Fecha mensaje
    public function testValidationDateRequired(): void
    {
        $message = $this->Message->newEntity([
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "La fecha es requerida.";
        $this->assertTrue($expected==$error["message_date"]["_required"]);
    }

    public function testValidationDateEmpty(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "La fecha no puede ser vacía.";
        $this->assertTrue($expected==$error["message_date"]["_empty"]);
    }

    public function testValidationDateTime(): void
    {
     
        $message = $this->Message->newEntity([
            'message_date' => '2022-11 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["message_date"]["dateTime"]);
    }

    public function testValidationBetweenValid(): void
    {
     
        $message = $this->Message->newEntity([
            'message_date' => '2021-11-10 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "La fecha del debe ser entre 2022 y 2050.";
        $this->assertTrue($error["message_date"]["custom"]==$expected);
    }
    

    //Title
    public function testValidationTitleEmpty(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => '',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El título no puede ser vacío.";
        $this->assertTrue($expected==$error["title"]["_empty"]);
    }

    public function testValidationTitleRequired(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El campo título es requerido.";
        $this->assertTrue($expected==$error["title"]["_required"]);
    }

    public function testValidationTitleMin(): void
    {
     
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'L',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El título debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["title"]["minLength"]);
    }

    public function testValidationTitleMax(): void
    {
     
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El título debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["title"]["maxLength"]);
    }
    public function testValidationTitleRegex(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'aaaaaaaaaaaaa$%%',
            'content' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El título debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["title"]["regex"]==$expected);
    }

    //Contenido
    public function testValidationContentEmpty(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => '',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El contenido no puede ser vacío.";
        $this->assertTrue($expected==$error["content"]["_empty"]);
    }

    public function testValidationContentRequired(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El campo contenido es requerido.";
        $this->assertTrue($expected==$error["content"]["_required"]);
    }

    public function testValidationContentMin(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'L',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);
        $error = $message->getErrors();
        $expected = "El contenido debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["content"]["minLength"]);
    }

    public function testValidationContentMax(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El contenido debe tener máximo 700 caracteres.";
        $this->assertTrue($expected==$error["content"]["maxLength"]);
    }
    public function testValidationContentRegex(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'aaaaaaaaaaaaa',
            'content' => 'Lorem ipsum d%$olor sit amet',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El contenido debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["content"]["regex"]==$expected);
    }


    //transmitter_user_id
    public function testValidationTransmitterUserIDInteger(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaa',
            'transmitter_user_id' => 'p',
            'receiver_user_id' => 1,
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El id del emisor debe ser un número entero.";
        $this->assertTrue($expected==$error["transmitter_user_id"]["integer"]);
    }

    //receiver_user_id
    public function testValidationeceiverUserIDInteger(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaa',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 'p',
            'readed' => 'yes',
        ]);

        $error = $message->getErrors();
        $expected = "El id del receptor debe ser un número entero.";
        $this->assertTrue($expected==$error["receiver_user_id"]["integer"]);
    }

    //Leido

    public function testValidationLeidoEmpty(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaa',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => '',
        ]);

        $error = $message->getErrors();
        $expected = "Leído no puede ser vacío.";
        $this->assertTrue($expected==$error["readed"]["_empty"]);
    }

    public function testValidationReadedRequired(): void
    {
     
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaa',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1
        ]);

        $error = $message->getErrors();
        $expected = "El campo leído es requerido.";
        $this->assertTrue($expected==$error["readed"]["_required"]);
    }

    public function testValidationReadedInlist(): void
    {
        $message = $this->Message->newEntity([
            'message_date' => '2022-11-16 09:12:04',
            'title' => 'Lorem ipsum dolor sit amet',
            'content' => 'aaaaa',
            'transmitter_user_id' => 1,
            'receiver_user_id' => 1,
            'readed' => 'yess',
        ]);

        $error = $message->getErrors();
        $expected = "Leído debe ser sí o no.";
        $this->assertTrue($expected==$error["readed"]["inList"]);
    }
}


