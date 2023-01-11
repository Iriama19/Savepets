<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PublicationStrayFixture
 */
class PublicationStrayFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'publication_stray';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'publication_id' => 1,
                'image' => '',
                'urgent' => 'no',
                'user_id' => 1,
            ],
        ];
        parent::init();
    }
}
