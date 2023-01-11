<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MessageFixture
 */
class MessageFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'message';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'message_date' => '2022-11-16 09:12:04',
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet',
                'transmitter_user_id' => 1,
                'receiver_user_id' => 1,
                'readed' => 'yes',
            ],
        ];
        parent::init();
    }
}
