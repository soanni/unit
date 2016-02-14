<?php

namespace tests;

class SecondTest extends \PHPUnit_Framework_TestCase
{
    public function testAsort(){
        $arr = array('bananas' => '2.01','oranges' => '2.02','kiwis' => '1.98','apples' => '1.99','pears' => '1.91');
        $sorted = array('pears' => '1.91','kiwis' => '1.98','apples' => '1.99','bananas' => '2.01','oranges' => '2.02');
        asort($arr,SORT_NUMERIC);
        //var_dump($arr);
        $this->assertSame($sorted,$arr);
    }

    public function testKsort(){
        $arr = array('bananas' => '2.01','oranges' => '2.02','kiwis' => '1.98','apples' => '1.99','pears' => '1.91');
        $sorted = array('apples' => '1.99','bananas' => '2.01','kiwis' => '1.98','oranges' => '2.02','pears' => '1.91');
        ksort($arr,SORT_STRING);
        //var_dump($arr);
        $this->assertSame($sorted,$arr);
    }
}
