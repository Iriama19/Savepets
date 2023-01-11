<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AnimalTable;
use Cake\TestSuite\TestCase;


/**
 * App\Model\Table\AnimalTable Test Case
 */
class AnimalTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\AnimalTable
     */
    protected $Animal;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Animal',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Animal') ? [] : ['className' => AnimalTable::class];
        $this->Animal = $this->getTableLocator()->get('Animal', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Animal);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\AnimalTable::validationDefault()
     */
    public function testValidationDefault(): void
    {     
        $animal = $this->Animal->newEntity([
            'name' => 'Validation',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick'
        ]);


        $hasErrors=$animal->hasErrors();
        $this->assertFalse($hasErrors);
    }

    //NOMBRE
    public function testValidationNameEmpty(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => '',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El nombre del animal no puede ser vacío.";
        $this->assertTrue($expected==$error["name"]["_empty"]);
    }

    public function testValidationNameRequired(): void
    {
     
        $animal = $this->Animal->newEntity([
            'image' => '',
            'specie' => 'cat',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El campo nombre es requerido.";
        $this->assertTrue($expected==$error["name"]["_required"]);
    }

    public function testValidationNameMin(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'k',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El nombre debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["name"]["minLength"]);
    }

    public function testValidationNameMax(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'pruebapruebapruebapruebapruebapruebaprueba',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El nombre debe tener máximo 30 caracteres.";
        $this->assertTrue($expected==$error["name"]["maxLength"]);
    }

    public function testValidationNameAlfabetico(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => '%vali%%',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "Introduce un nombre con caracteres alfabéticos y espacios.";
        $this->assertTrue($error["name"]["regex"]==$expected);
    }

    //Especie
    public function testValidationSpecieRequired(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El campo especie es requerido.";
        $this->assertTrue($expected==$error["specie"]["_required"]);
    }

    public function testValidationSpecieEmpty(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => '',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);


        $error = $animal->getErrors();
        $expected = "La especie no puede ser vacía.";
        $this->assertTrue($expected==$error["specie"]["_empty"]);
    }

    public function testValidationSpecieInList(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'elefante',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La especie debe ser una de las existentes.";
        $this->assertTrue($expected==$error["specie"]["inList"]);
    }

    //Chip
    public function testValidationChipInList(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'nop',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "Chip debe ser sí o no.";
        $this->assertTrue($expected==$error["chip"]["inList"]);
    }

    //Sex
    public function testValidationSexRequired(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El campo sexo es requerido.";
        $this->assertTrue($expected==$error["sex"]["_required"]);
    }

    public function testValidationSexEmpty(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => '',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick',]);

        $error = $animal->getErrors();
        $expected = "El sexo no puede ser vacío.";
        $this->assertTrue($expected==$error["sex"]["_empty"]);
    }

    public function testValidationSexInList(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'castrado',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "El sexo debe ser de uno de los valores existentes.";
        $this->assertTrue($expected==$error["sex"]["inList"]);
    }

    //Raza

    public function testValidationRaceAlfabetico(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat%%&%',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "Introduce una raza con caracteres alfabéticos y espacios.";
        $this->assertTrue($error["race"]["regex"]==$expected);
    }

    public function testValidationRaceMax(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'VAli',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'perroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperroperro',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La raza debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["race"]["maxLength"]);
    }

    //Edad
    public function testValidationAgeInteger(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'perro',
            'age' => 'ee',
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La edad debe ser un número.";
        $this->assertTrue($expected==$error["age"]["integer"]);
    }

    public function testValidationAgeMax(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'VAli',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'perro',
            'age' => 300,
            'information' => 'Es pequeño',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La edad máxima es 200 años.";
        $this->assertTrue($expected==$error["age"]["custom"]);
    }
    //Información
    public function testValidationInformationMax(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'VAli',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'perro',
            'age' => 1,
            'information' => 'informationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinformationinfo',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La información debe tener máximo 300 caracteres.";
        $this->assertTrue($expected==$error["information"]["maxLength"]);
    }

    public function testValidationInformationRegex(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'VAli',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'perro',
            'age' => 1,
            'information' => 'inform$$',
            'state' => 'sick']);

        $error = $animal->getErrors();
        $expected = "La información debe contener solo caracteres alfabéticos, espacios y algunos símbolos [. , º ].";
        $this->assertTrue($error["information"]["regex"]==$expected);
    }

    //Estado
    public function testValidationStateRequired(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño']);

        $error = $animal->getErrors();
        $expected = "El campo estado es requerido.";
        $this->assertTrue($expected==$error["state"]["_required"]);
    }

    public function testValidationStateEmpty(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => '']);

        $error = $animal->getErrors();
        $expected = "El estado no puede ser vacío.";
        $this->assertTrue($expected==$error["state"]["_empty"]);
    }

    public function testValidationStateInList(): void
    {
     
        $animal = $this->Animal->newEntity([
            'name' => 'Vali',
            'image' => '',
            'specie' => 'dog',
            'chip' => 'no',
            'sex' => 'intact_male',
            'race' => 'cat',
            'age' => 1,
            'information' => 'Es pequeño',
            'state' => 'enfermo']);

        $error = $animal->getErrors();
        $expected = "El estado debe ser de uno de los valores existentes.";
        $this->assertTrue($expected==$error["state"]["inList"]);
    }


}
