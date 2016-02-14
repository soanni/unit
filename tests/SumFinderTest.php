<?php

namespace tests;

require_once('../src/SumFinder.php');

class SumFinderTest extends \PHPUnit_Framework_TestCase
{
    public function testSumFinder(){
        $input = array(0,1,2,3,6,7,8,9,11,12,14);
        $result = array('group' => '6,7,8,9','sum' => 30);
        $this->assertEquals($result,sumFinder($input));
    }

    public function testCompareArrays(){
        $a = array(0,1,2,3);
        $b = array(6,7,8,9);
        $this->assertEquals(-1,compareArrays($a,$b));
        $this->assertEquals(1,compareArrays($b,$a));
        $this->assertEquals(0,compareArrays($b,$b));
    }

}
