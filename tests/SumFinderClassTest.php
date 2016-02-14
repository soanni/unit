<?php

namespace tests;

use src\SumFinderClass;

require_once('../src/SumFinderClass.php');

class SumFinderClassTest extends \PHPUnit_Framework_TestCase
{
    public function testSumFinder(){
        $input = array(0,1,2,3,6,7,8,9,11,12,14);
        $result = array('group' => '6,7,8,9','sum' => 30);
        $sumFinder = new SumFinderClass($input);
        $this->assertEquals($result,$sumFinder->findSum());
    }

    public function testCompareArrays(){
        $a = array(0,1,2,3);
        $b = array(6,7,8,9);
        $sumFinder = new SumFinderClass();
        $this->assertEquals(-1,$sumFinder->compareArrays($a,$b));
        $this->assertEquals(1,$sumFinder->compareArrays($b,$a));
        $this->assertEquals(0,$sumFinder->compareArrays($b,$b));
    }
}
