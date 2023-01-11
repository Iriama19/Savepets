<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PublicationHelpFixture
 */
class PublicationHelpFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'publication_help';
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
                'categorie' => 'textile',
                'user_id' => 1
            ],
        ];
        parent::init();
    }
}
