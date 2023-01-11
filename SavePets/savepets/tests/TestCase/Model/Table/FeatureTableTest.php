<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FeatureTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FeatureTable Test Case
 */
class FeatureTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FeatureTable
     */
    protected $Feature;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
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
        $config = $this->getTableLocator()->exists('Feature') ? [] : ['className' => FeatureTable::class];
        $this->Feature = $this->getTableLocator()->get('Feature', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Feature);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FeatureTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $feature = $this->Feature->newEntity([
            'key_feature' => 'nueva'
        ]);

        $error = $feature->getErrors();
        $hasErrors=$feature->hasErrors();
        $this->assertFalse($hasErrors);     
    }

    public function testValidationkey_featureEmpty(): void
    {
        $feature = $this->Feature->newEntity([
            'key_feature' => ''
        ]);

        $error = $feature->getErrors();
        $expected = "La clave no puede ser vacía.";
        $this->assertTrue($expected==$error["key_feature"]["_empty"]);
    }

    public function testValidationkey_featureRequired(): void
    {
     
        $feature = $this->Feature->newEntity([
        ]);

        $error = $feature->getErrors();
        $expected = "El campo clave es requerido.";
        $this->assertTrue($expected==$error["key_feature"]["_required"]);
    }

    public function testValidationkey_featureMin(): void
    {
        $feature = $this->Feature->newEntity([
            'key_feature' => 'ss'
        ]);


        $error = $feature->getErrors();
        $expected = "La clave debe tener mínimo 3 caracteres.";
        $this->assertTrue($expected==$error["key_feature"]["minLength"]);
    }

    public function testValidationkey_featureMax(): void
    {
     
        $feature = $this->Feature->newEntity([
            'key_feature' => 'aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa'
        ]);

        $error = $feature->getErrors();
        $expected = "La clave debe tener máximo 100 caracteres.";
        $this->assertTrue($expected==$error["key_feature"]["maxLength"]);
    }

    public function testValidationkey_featureUnique(): void
    {
        $feature = $this->Feature->newEntity([
            'key_feature' => 'aaaa'
        ]);

        $error = $feature->getErrors();
        $expected = "La clave debe ser única.";
        $this->assertTrue($error["key_feature"]["unique"]==$expected);
    }

}
