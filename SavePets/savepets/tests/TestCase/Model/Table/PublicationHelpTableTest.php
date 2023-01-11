<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\PublicationHelpTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\PublicationHelpTable Test Case
 */
class PublicationHelpTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\PublicationHelpTable
     */
    protected $PublicationHelp;

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
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('PublicationHelp') ? [] : ['className' => PublicationHelpTable::class];
        $this->PublicationHelp = $this->getTableLocator()->get('PublicationHelp', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->PublicationHelp);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\PublicationHelpTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 1,
            'categorie' => 'textile',
            'user_id' => 1
        ]);

        $hasErrors=$publicationhelp->hasErrors();
        $this->assertFalse($hasErrors);
    }

    //Publication_id
    public function testValidationPublicationIDInteger(): void
    {
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 'pe',
            'categorie' => 'textile',
            'user_id' => 1
        ]);
        $error = $publicationhelp->getErrors();
        $expected = "El índice de la publicación debe ser un entero.";
        $this->assertTrue($expected==$error["publication_id"]["integer"]);
    }

    //Categoria

    public function testValidationCategorieEmpty(): void
    {
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 1,
            'categorie' => '',
            'user_id' => 1
        ]);
        $error = $publicationhelp->getErrors();
        $expected = "La categoría no puede ser vacía.";
        $this->assertTrue($expected==$error["categorie"]["_empty"]);
    }

    public function testValidationCategorieRequired(): void
    {
     
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 1,
            'user_id' => 1
        ]);
        $error = $publicationhelp->getErrors();
        $expected = "El campo categoría es requeria.";
        $this->assertTrue($expected==$error["categorie"]["_required"]);
    }

    public function testValidationCategorieInlist(): void
    {
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 1,
            'categorie' => 'textileo',
            'user_id' => 1
        ]);
        $error = $publicationhelp->getErrors();
        $expected = "La categoría debe ser una de las existentes.";
        $this->assertTrue($expected==$error["categorie"]["inList"]);
    }

    //User_id
    public function testValidationUserIDInteger(): void
    {
        $publicationhelp = $this->PublicationHelp->newEntity([
            'publication_id' => 1,
            'categorie' => 'textile',
            'user_id' => 'pe'
        ]);
        $error = $publicationhelp->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }


}
