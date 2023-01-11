<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PublicationAdoptionFixture
 */
class PublicationAdoptionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'publication_adoption';
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
                'animal_id' => 1,
                'urgent' => 'yes',
                'user_id' => 1
            ],
        ];
        parent::init();
    }
}
