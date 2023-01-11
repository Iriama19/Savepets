<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AddressFixture
 */
class AddressFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'address';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'province' => 'Pontevedra',
                'postal_code' => 35004,
                'country' => 'Lorem',
                'city' => 'Loremo',
                'street' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
