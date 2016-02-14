<?php

namespace tests;
use util\MockTester;

require_once('../util/MockTester.php');

class MockTesterTest extends \PHPUnit_Framework_TestCase
{
    public function testOne()
    {
        $mockTester = $this->getMock('\util\MockTester',array('getTwo'));
        $this->assertEquals(1,$mockTester->getOne());
        $this->assertEquals(2,$mockTester->getTwo());
    }

    public function testTwo()
    {
        $mockTester = $this->getMock('\util\MockTester',null);
        $this->assertEquals(1,$mockTester->getOne());
        $this->assertEquals(2,$mockTester->getTwo());
    }
}
