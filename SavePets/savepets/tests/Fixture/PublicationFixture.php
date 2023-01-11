<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PublicationFixture
 */
class PublicationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'publication';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'publication_date' => '2022-11-05 21:59:41',
                'title' => 'Lorem ipsum dolor sit amet',
                'message' => 'Lorem ipsum dolor sit amet'
            ],
        ];
        parent::init();
    }
}
