<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * FeatureFixture
 */
class FeatureFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'feature';
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
                'key_feature' => 'aaaa',
            ],
        ];
        parent::init();
    }
}
