<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AnimalFixture
 */
class AnimalFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'animal';
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [                   
                'name' => 'Lorem',
                'image' => '',
                'specie' => 'cat',
                'chip' => 'yes',
                'sex' => 'intact_male',
                'race' => 'persia',
                'age' => 1,
                'information' => 'Es pequeño',
                'state' => 'sick',
            ],
            [
                'name' => 'Lor',
                'image' => '',
                'specie' => 'dog',
                'chip' => 'no',
                'sex' => 'intact_female',
                'race' => 'cat',
                'age' => 1,
                'information' => 'Es pequeño',
                'state' => 'sick',
            ],
            [   
                'name' => 'Lore',
                'image' => '',
                'specie' => 'cat',
                'chip' => 'yes',
                'sex' => 'intact_male',
                'race' => 'gato',
                'age' => 1,
                'information' => 'Es un gato',
                'state' => 'sick',
            ],
        ];
        parent::init();
    }
}
