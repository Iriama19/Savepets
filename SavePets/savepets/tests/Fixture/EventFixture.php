<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * EventFixture
 */
class EventFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'event';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'title' => 'Lorem ipsum dolor sit amet',
                'message' => 'Lorem ipsum dolor sit amet',
                'start_date' => '2022-11-12 16:35:38',
                'end_date' => '2022-11-13 16:35:38',
                'user_id' => 1,
                'addres_id' => 1
            ],
        ];
        parent::init();
    }
}
