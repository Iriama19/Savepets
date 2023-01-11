<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FosterListUserFixture
 */
class FosterListUserFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'foster_list_user';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'foster_list_id' => 1,
                'user_id' => 1,
                'specie' => 'cat',
                'foster_date' => '2022-11-16 17:40:32',
            ],
        ];
        parent::init();
    }


}
