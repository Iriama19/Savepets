<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\UserTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\UserTable Test Case
 */
class UserTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\UserTable
     */
    protected $User;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('User') ? [] : ['className' => UserTable::class];
        $this->User = $this->getTableLocator()->get('User', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->User);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\UserTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $hasErrors=$user->hasErrors();
        $this->assertFalse($hasErrors);       
    
    }

    //DNI
    public function testValidationDNICIFEmpty(): void
    {
        $user = $this->User->newEntity([
            'DNI_CIF' => '',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El DNI/NIE/CIF no puede ser vacío.";
        $this->assertTrue($expected==$error["DNI_CIF"]["_empty"]);
    }

    public function testValidationDNICIFRequired(): void
    {
     
        $user = $this->User->newEntity([
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El campo DNI/CIF/NIE es requerido.";
        $this->assertTrue($expected==$error["DNI_CIF"]["_required"]);
    }

    public function testValidationDNICIFMin(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '22',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El DNI/NIE/CIF debe tener mínimo 8 caracteres.";
        $this->assertTrue($expected==$error["DNI_CIF"]["minLength"]);
    }

    public function testValidationDNICIFMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '2217539895Z',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El DNI/NIE/CIF debe tener máximo 9 caracteres.";
        $this->assertTrue($expected==$error["DNI_CIF"]["maxLength"]);
    }

    public function testValidationDNICIFUnique(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '22175395Z',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El DNI/NIE/CIF debe ser único.";
        $this->assertTrue($error["DNI_CIF"]["unique"]==$expected);
    }

    public function testValidationDNICIFFormat(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '2217539ZZ',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "Introduce un DNI/NIE/CIF en el formato correcto.";
        $this->assertTrue($error["DNI_CIF"]["regex"]==$expected);
    }


    public function testValidationDNICIFValid(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El DNI/NIE/CIF debe ser válido.";
        $this->assertTrue($error["DNI_CIF"]["custom"]==$expected);
    }

    //Nombre
    public function testValidationNameEmpty(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => '',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El nombre no puede ser vacío.";
        $this->assertTrue($expected==$error["name"]["_empty"]);
    }

    public function testValidationNameRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El campo nombre es requerido.";
        $this->assertTrue($expected==$error["name"]["_required"]);
    }

    public function testValidationNameMin(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => 'pr',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);
        $error = $user->getErrors();
        $expected = "El nombre debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["name"]["minLength"]);
    }

    public function testValidationNameMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => 'PruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPrueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El nombre debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["name"]["maxLength"]);
    }

    public function testValidationNameAlfabetico(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueb%&/%&a',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1]);

        $error = $user->getErrors();
        $expected = "Introduce un nombre con caracteres alfabéticos y espacios.";
        $this->assertTrue($error["name"]["regex"]==$expected);
    }

    //Apellido
    public function testValidationLastNameMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => 'Prueba',
            'lastname' => 'PruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPruebaPrueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El apellido debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["lastname"]["maxLength"]);
    }

    public function testValidationLastNameAlfabetico(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => '15820872P',
            'name' => 'Prueba',
            'lastname' => 'pejfkw%&',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1]);

        $error = $user->getErrors();
        $expected = "Introduce un apellido con caracteres alfabéticos y espacios.";
        $this->assertTrue($error["lastname"]["regex"]==$expected);
    }

    //Username

    public function testValidationUsernameEmpty(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => '',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El alias de usuario no puede ser vacío.";
        $this->assertTrue($expected==$error["username"]["_empty"]);
    }

    public function testValidationUserameRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El campo alias de usuario es requerido.";
        $this->assertTrue($expected==$error["username"]["_required"]);
    }

    public function testValidationUsernameMin(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'k',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $expected = "El alias de usuario debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["username"]["minLength"]);
    }

    public function testValidationUsernameMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'PruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El alias de usuario debe tener máximo 30 caracteres.";
        $this->assertTrue($expected==$error["username"]["maxLength"]);
    }

    public function testValidationUserameAlfabetico(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavali%&$dation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1]);

        $error = $user->getErrors();
        $expected = "Introduce un alias de usuario alfanumérico.";
        $this->assertTrue($error["username"]["regex"]==$expected);
    }

    public function testValidationUsernameUnique(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Prueba',
            'password' => 'prueba',
            'email' => 'pruebaaa@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1,
        ]);

        $error = $user->getErrors();
        $expected = "El alias de usuario debe ser único.";
        $this->assertTrue($error["username"]["unique"]==$expected);
    }

    //Contraseña
    public function testValidationPasswordEmpty(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebaaaa',
            'password' => '',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "La contraseña no puede ser vacía.";
        $this->assertTrue($expected==$error["password"]["_empty"]);
    }

    public function testValidationPasswordRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebaaaa',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El campo contraseña es requerido.";
        $this->assertTrue($expected==$error["password"]["_required"]);
    }

    public function testValidationPasswordMin(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'kkkkkk',
            'password' => 'a',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $expected = "La contraseña debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["password"]["minLength"]);
    }

    public function testValidationPasswordMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebaaaa',
            'password' => 'pruePruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationPruebavalidationba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "La contraseña debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["password"]["maxLength"]);
    }

    //Email
    public function testValidationEmailEmpty(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => '',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El email no puede ser vacío.";
        $this->assertTrue($expected==$error["email"]["_empty"]);
    }

    public function testValidationEmailRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El campo email es requerido.";
        $this->assertTrue($expected==$error["email"]["_required"]);
    }

    public function testValidationEmailFormato(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmailcom',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1]);

        $error = $user->getErrors();
        $expected = "Debe seguir un formato de email.";
        $this->assertTrue($error["email"]["email"]==$expected);
    }

    public function testValidationEmailUnique(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'prueba@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El email debe ser único.";
        $this->assertTrue($error["email"]["unique"]==$expected);
    }

    //Telefono

    public function testValidationPhoneEmpty(): void
    {
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El teléfono no puede ser vacío.";
        $this->assertTrue($expected==$error["phone"]["_empty"]);
    }

    public function testValidationPhoneRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El campo teléfono es requerido.";
        $this->assertTrue($expected==$error["phone"]["_required"]);
    }

    public function testValidationPhoneMin(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '7',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El teléfono debe tener mínimo 9 caracteres.";
        $this->assertTrue($expected==$error["phone"]["minLength"]);
    }

    public function testValidationPhoneMax(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '1234567890123456',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El teléfono debe tener máximo 15 caracteres.";
        $this->assertTrue($expected==$error["phone"]["maxLength"]);
    }

    public function testValidationPhoneUnique(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087621',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "El teléfono debe ser único.";
        $this->assertTrue($error["phone"]["unique"]==$expected);
    }

    public function testValidationPhoneFormat(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '-639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 1
        ]);

        $error = $user->getErrors();
        $expected = "Introduce un formato de teléfono correcto.";
        $this->assertTrue($error["phone"]["regex"]==$expected);
    }

    //Rol

    public function testValidationRoleEmpty(): void
    {
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => '',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $expected = "El rol no puede ser vacío.";
        $this->assertTrue($expected==$error["role"]["_empty"]);
    }

    public function testValidationRoleRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $expected = "El campo rol es requerido.";
        $this->assertTrue($expected==$error["role"]["_required"]);
    }

    public function testValidationRoleInlist(): void
    {
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'estandar',
            'addres_id' => 1
        ]);
        $error = $user->getErrors();
        $expected = "El rol de usuario debe ser estándar, protectora o administrador.";
        $this->assertTrue($expected==$error["role"]["inList"]);
    }

    //Addres_id
    public function testValidationAddresIDInteger(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date' => '1999-12-14',
            'role' => 'standar',
            'addres_id' => 'pe'
        ]);

        $error = $user->getErrors();
        $expected = "El identificador de la dirección es un número.";
        $this->assertTrue($expected==$error["addres_id"]["integer"]);
    }

    //Birth_date

    public function testValidationBirthDateRequired(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'role' => 'standar',
            'addres_id' => 'pe'
        ]);
        $error = $user->getErrors();
        $expected = "El campo fecha de nacimiento es requerido.";
        $this->assertTrue($expected==$error["birth_date"]["_required"]);
    }

    public function testValidationBirthDateEmpty(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date'=>'',
            'role' => 'standar',
            'addres_id' => 'pe'
        ]);
        $error = $user->getErrors();
        $expected = "La fecha de nacimiento no puede ser vacía.";
        $this->assertTrue($expected==$error["birth_date"]["_empty"]);
    }
    public function testValidationBirthDateValid(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date'=>'2020-09-09',
            'role' => 'standar',
            'addres_id' => 'pe'
        ]);
        $error = $user->getErrors();
        $expected = "El usuario debe ser mayor de edad.";
        $this->assertTrue($expected==$error["birth_date"]["custom"]);
    }
    public function testValidationBirthDateFormat(): void
    {
     
        $user = $this->User->newEntity([
            'DNI_CIF' => 'X2696181Y',
            'name' => 'Prueba',
            'lastname' => 'Prueba Prueba',
            'username' => 'Pruebavalidation',
            'password' => 'prueba',
            'email' => 'pruebabien@gmail.com',
            'phone' => '639087620',
            'birth_date'=>'2020-09',
            'role' => 'standar',
            'addres_id' => 'pe'
        ]);
        $error = $user->getErrors();
        $expected = "La fecha de nacimiento introducida debe seguir un formato de fecha.";
        $this->assertTrue($expected==$error["birth_date"]["date"]);
    }
}
