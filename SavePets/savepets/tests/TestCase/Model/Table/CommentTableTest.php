<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\CommentTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\CommentTable Test Case
 */
class CommentTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\CommentTable
     */
    protected $Comment;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Comment',
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
        $config = $this->getTableLocator()->exists('Comment') ? [] : ['className' => CommentTable::class];
        $this->Comment = $this->getTableLocator()->get('Comment', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Comment);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\CommentTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'Lorem ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $hasErrors=$comment->hasErrors();
        $this->assertFalse($hasErrors);    
    }

    //Comment_date
    public function testValidationDateRequired(): void
    {
     
        $comment = $this->Comment->newEntity([
            'message' => 'Lorem ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El campo fecha de comentario es requerido.";
        $this->assertTrue($expected==$error["comment_date"]["_required"]);
    }

    public function testValidationDateEmpty(): void
    {
     
        $comment = $this->Comment->newEntity([
            'comment_date' => '',
            'message' => 'Lorem ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "La fecha no puede ser vacía.";
        $this->assertTrue($expected==$error["comment_date"]["_empty"]);
    }

    public function testValidationDateTime(): void
    {
     
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11 21:13:02',
            'message' => 'Lorem ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["comment_date"]["dateTime"]);
    }

    public function testValidationDateBetweenValid(): void
    {
     
        $comment = $this->Comment->newEntity([
            'comment_date' => '2020-11-09 21:13:02',
            'message' => 'Lorem ipsum dolor sit amet',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "La fecha de comentario debe ser entre 2022 y 2050.";
        $this->assertTrue($error["comment_date"]["custom"]==$expected);
    }

    //Mensaje
    public function testValidationMessageEmpty(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => '',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El mensaje no puede ser vacío.";
        $this->assertTrue($expected==$error["message"]["_empty"]);
    }

    public function testValidationMensajeRegex(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'dsdvd% sef',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El mensaje debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["message"]["regex"]==$expected);
    }
    public function testValidationMessageRequired(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El campo mensaje es requerido.";
        $this->assertTrue($expected==$error["message"]["_required"]);
    }

    public function testValidationMessageMin(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'Lo',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El mensaje debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["message"]["minLength"]);
    }

    public function testValidationMessageMax(): void
    {
     
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaassss',
            'publication_id' => 1,
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El mensaje debe tener máximo 300 caracteres.";
        $this->assertTrue($expected==$error["message"]["maxLength"]);
    }

    //Publication_id
    public function testValidationPublicationIDInteger(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'aaaa',
            'publication_id' => 'e',
            'user_id' => 1
        ]);

        $error = $comment->getErrors();
        $expected = "El índice de publicación debe ser un entero.";
        $this->assertTrue($expected==$error["publication_id"]["integer"]);
    }  

    //User_id
    public function testValidationUserIDInteger(): void
    {
        $comment = $this->Comment->newEntity([
            'comment_date' => '2022-11-09 21:13:02',
            'message' => 'aaaa',
            'publication_id' => 1,
            'user_id' => 'p'
        ]);

        $error = $comment->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }


}
