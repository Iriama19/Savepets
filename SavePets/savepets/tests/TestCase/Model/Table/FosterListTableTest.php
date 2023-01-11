<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\FosterListTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\FosterListTable Test Case
 */
class FosterListTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\FosterListTable
     */
    protected $FosterList;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.FosterList',
        'app.User',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('FosterList') ? [] : ['className' => FosterListTable::class];
        $this->FosterList = $this->getTableLocator()->get('FosterList', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->FosterList);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\FosterListTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $fosterlist = $this->FosterList->newEntity([
            'user_id' => 2
        ]);

        $hasErrors=$fosterlist->hasErrors();
        $this->assertFalse($hasErrors);    
    }
    
    public function testValidationUserIDUnique(): void
    {
     
        $fosterlist = $this->FosterList->newEntity([
            'user_id' => 1
        ]);
        $error = $fosterlist->getErrors();
        $expected = "El usuario debe ser único.";
        $this->assertTrue($error["user_id"]["unique"]==$expected);
    }


}
