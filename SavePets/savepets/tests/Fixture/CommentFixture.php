<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * CommentFixture
 */
class CommentFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'comment';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'comment_date' => '2022-11-09 21:13:02',
                'message' => 'Lorem ipsum dolor sit amet',
                'publication_id' => 1,
                'user_id' => 1
            ],
        ];
        parent::init();
    }
}
