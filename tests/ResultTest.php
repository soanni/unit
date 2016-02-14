<?php

namespace tests;


class ResultTest extends \PHPUnit_Framework_TestCase
{
    public function testSucceeds(){
        $this->assertEquals(2,2/1);
    }

    public function testFails(){
        $this->assertEquals(1,2/1);
    }

    public function testError(){
        $this->assertEquals(1,2/0);
    }

    public function testSkipped(){
        $this->markTestSkipped('We don\'t want to test it now');
        $this->assertEquals(2,2/1);
    }

    public function testIncomplete(){
        $this->markTestIncomplete('Needs to be implemented');
        $this->assertEquals(2,2/1);
    }
}
