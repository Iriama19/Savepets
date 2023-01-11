<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnimalAdoptionFixture
 */
class AnimalAdoptionFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'animal_adoption';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'start_date' => '2022-11-02 20:45:51',
                'end_date' => '2022-11-02 20:45:51',
                'user_id' => 1,
                'animal_id' => 1,
            ],
        ];
        parent::init();
    }
}
