<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeatureUserTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeatureUserTable Test Case
 */
class FeatureUserTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeatureUserTable
     */
    protected $FeatureUser;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FeatureUser',
        'app.User',
        'app.Feature',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FeatureUser') ? [] : ['className' => FeatureUserTable::class];
        $this->FeatureUser = $this->getTableLocator()->get('FeatureUser', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FeatureUser);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FeatureUserTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $featureuser = $this->FeatureUser->newEntity([
            'user_id' => 1,
            'feature_id' => 1,
            'value' => 'jnjk'
        ]);

        $error = $featureuser->getErrors();
        $hasErrors=$featureuser->hasErrors();
        $this->assertFalse($hasErrors);     
        }

    public function testValidationValueMax(): void
    {
        $featureuser = $this->FeatureUser->newEntity([
            'user_id' => 1,
            'feature_id' => 1,
            'value' => 'sssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss'
        ]);

        $error = $featureuser->getErrors();
        $expected = "El valor debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["value"]["maxLength"]);
    }
    //User_id
    public function testValidationUserIDInteger(): void
    {
        $featureuser = $this->FeatureUser->newEntity([
            'user_id' => 'pe',
            'feature_id' => 1,
            'value' => 'Lorem ipsum dolor sit amet'
        ]);

        $error = $featureuser->getErrors();
        $expected = "El índice del usuario debe ser un entero.";
        $this->assertTrue($expected==$error["user_id"]["integer"]);
    }

    //Feature
        public function testValidationFeatureIDInteger(): void
        {
            $featureuser = $this->FeatureUser->newEntity([
                'user_id' => 1,
                'feature_id' => 'pe',
                'value' => 'Lorem ipsum dolor sit amet'
            ]);
    
            $error = $featureuser->getErrors();

            $expected = "El índice de la característica debe ser un entero.";
            $this->assertTrue($expected==$error["feature_id"]["integer"]);
        }

}
