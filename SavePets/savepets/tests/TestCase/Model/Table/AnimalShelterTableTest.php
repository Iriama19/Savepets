<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnimalShelterTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AnimalShelterTable Test Case
 */
class AnimalShelterTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnimalShelterTable
     */
    protected $AnimalShelter;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.AnimalShelter',
        'app.User',
        'app.Animal',
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
        $config = $this->getTableLocator()->exists('AnimalShelter') ? [] : ['className' => AnimalShelterTable::class];
        $this->AnimalShelter = $this->getTableLocator()->get('AnimalShelter', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->AnimalShelter);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AnimalShelterTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2022-11-03 10:47:38',
            'end_date' => '2022-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1
        ]);

        $hasErrors=$animalshelter->hasErrors();
        $this->assertFalse($hasErrors);    
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\AnimalShelterTable::buildRules()
     */
    // public function testBuildRules(): void
    // {
    //     $this->markTestIncomplete('Not implemented yet.');
    // }

    //Start_date
    public function testValidationStartDateRequired(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'end_date' => '2022-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1
        ]);

        $error = $animalshelter->getErrors();
        $expected = "El campo fecha de inicio es requerido.";
        $this->assertTrue($expected==$error["start_date"]["_required"]);
    }

    public function testValidationStartDateEmpty(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '',
            'end_date' => '2022-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "El campo de la fecha de inicio no puede estar vacío.";
        $this->assertTrue($expected==$error["start_date"]["_empty"]);
    }

    public function testValidationStartDateDateTime(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2022-10',
            'end_date' => '2022-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "La fecha de inicio introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["start_date"]["dateTime"]);
    }

    public function testValidationStartDateBetweenValid(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '1980-11-03 10:47:38',
            'end_date' => '2022-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "La fecha de inicio debe ser entre 1990 y 2050.";
        $this->assertTrue($error["start_date"]["custom"]==$expected);
    }
    //end-date
    public function testValidationEndDateDateTime(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2022-10-02 10:47:38',
            'end_date' => '2022-11',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "La fecha de fin introducida debe seguir un formato de fecha y hora correcto.";
        $this->assertTrue($expected==$error["end_date"]["dateTime"]);
    }

    public function testValidationEndDateBetweenValid(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2020-11-03 10:47:38',
            'end_date' => '2060-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "La fecha de fin debe ser entre 1990 y 2050.";
        $this->assertTrue($error["end_date"]["custom"]==$expected);
    }


    public function testValidationEndLatterValid(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2020-11-03 10:47:38',
            'end_date' => '2019-11-03 10:47:38',
            'user_id' => 1,
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "La fecha de fin tiene que ser más tarde que la de inicio.";
        $this->assertTrue($error["end_date"]["endlatter"]==$expected);
    }
    //User_id
    public function testValidationUserIDInteger(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2022-10-02 10:47:38',
            'end_date' => '2022-10-04 10:47:38',
            'user_id' => 'efe',
            'animal_id' => 1]);

        $error = $animalshelter->getErrors();
        $expected = "El identificador del usuario es un número.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }

    //Animal_id
    public function testValidationAnimalIDInteger(): void
    {
     
        $animalshelter = $this->AnimalShelter->newEntity([
            'start_date' => '2022-10-02 10:47:38',
            'end_date' => '2022-10-04 10:47:38',
            'user_id' => 1,
            'animal_id' => 'pp']);

        $error = $animalshelter->getErrors();
        $expected = "El identificador del animal es un número.";
        $this->assertTrue($expected==$error["animal_id"]["integer"]);
    }

}
