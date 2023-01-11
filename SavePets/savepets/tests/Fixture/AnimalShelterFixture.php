<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnimalShelterFixture
 */
class AnimalShelterFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'animal_shelter';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'start_date' => '2022-11-03 10:47:38',
                'end_date' => '2022-11-03 10:47:38',
                'user_id' => 1,
                'animal_id' => 1,
            ],
        ];
        parent::init();
    }
}
