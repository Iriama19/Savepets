<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UserFixture
 */
class UserFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'user';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'DNI_CIF' => '22175395Z',
                'name' => 'Prueba',
                'lastname' => 'Prueba Prueba',
                'username' => 'Prueba',
                'password' => 'prueba',
                'email' => 'prueba@gmail.com',
                'phone' => '639087621',
                'role' => 'standar',
                'birth_date' => '2000-12-14',
                'addres_id' => 1,
            ],
            [
                'DNI_CIF' => '65401012Y',
                'name' => 'Prueba',
                'lastname' => 'Prueba Prueba',
                'username' => 'Pruebados',
                'password' => 'prueba',
                'email' => 'pruebados@gmail.com',
                'phone' => '639087521',
                'role' => 'standar',
                'birth_date' => '1999-12-14',
                'addres_id' => 1,
            ],
        ];
        parent::init();
    }
}
