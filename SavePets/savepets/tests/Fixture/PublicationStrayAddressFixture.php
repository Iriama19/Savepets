<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PublicationStrayAddressFixture
 */
class PublicationStrayAddressFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'publication_stray_address';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'publication_stray_id' => 1,
                'addres_id' => 1,
                'user_id' => 1,
                'publication_date' => '2022-11-08 11:24:05',
                'image' => ''
            ],
        ];
        parent::init();
    }
}
