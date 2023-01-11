<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FosterListUserTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FosterListUserTable Test Case
 */
class FosterListUserTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FosterListUserTable
     */
    protected $FosterListUser;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterListUser',
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
        $config = $this->getTableLocator()->exists('FosterListUser') ? [] : ['className' => FosterListUserTable::class];
        $this->FosterListUser = $this->getTableLocator()->get('FosterListUser', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FosterListUser);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FosterListUserTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 17:40:32'
        ]);


        $hasErrors=$fosterlistuser->hasErrors();
        $this->assertFalse($hasErrors);
    }

    //FosterList_id
    public function testValidationFosterListIDInteger(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 'o',
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '2022-11-16 17:40:32',
        ]);
        $error = $fosterlistuser->getErrors();
        $expected = "El índice de la lista de adopción debe ser un entero.";
        $this->assertTrue($expected==$error["foster_list_id"]["integer"]);
    }
    
    //User_id
    public function testValidationUserIDInteger(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 'k',
            'specie' => 'cat',
            'foster_date' => '2022-11-16 17:40:32',
        ]);
        $error = $fosterlistuser->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }



    //Especie

    public function testValidationSpecieEmpty(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => '',
            'foster_date' => '2022-11-16 17:40:32',
        ]);
        $error = $fosterlistuser->getErrors();
        $expected = "La especie no puede ser vacía.";
        $this->assertTrue($expected==$error["specie"]["_empty"]);
    }

    public function testValidationSpecieRequired(): void
    {
     
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'foster_date' => '2022-11-16 17:40:32',
        ]);
        $error = $fosterlistuser->getErrors();
        $expected = "El campo especie es requerido.";
        $this->assertTrue($expected==$error["specie"]["_required"]);
    }

    public function testValidationSpecieInlist(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'catt',
            'foster_date' => '2022-11-16 17:40:32',
        ]);
        $error = $fosterlistuser->getErrors();
        $expected = "La especie debe ser una de las opciones.";
        $this->assertTrue($expected==$error["specie"]["inList"]);
    }

    //Foster date

    public function testValidationDateTime(): void
    {
     
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '2022-11 17:40:32'
        ]);

        $error = $fosterlistuser->getErrors();
        $expected = "La fecha introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["foster_date"]["dateTime"]);
    }
    public function testValidationDateBetweenValid(): void
    {
        $fosterlistuser = $this->FosterListUser->newEntity([
            'foster_list_id' => 1,
            'user_id' => 1,
            'specie' => 'cat',
            'foster_date' => '1980-11-10 17:40:32'
        ]);

        $error = $fosterlistuser->getErrors();
        $expected = "La fecha de la lista de acogida debe ser entre 1990 y 2050.";
        $this->assertTrue($error["foster_date"]["custom"]==$expected);
    }
}
