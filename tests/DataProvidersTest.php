<?php

namespace tests;


class DataProvidersTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return array
     */
    public function providerArray()
    {
        $inputOne = array(1,2,3,4,5);
        $inputTwo = array(10,20,30,40,50);
        $inputThree = array(100,200,300,400,500);
        return [
            [
                'inputArray' => $inputOne
            ],
            [
                'inputArray' => $inputTwo
            ],
            [
                'inputArray' => $inputThree
            ]
        ];
    }

    /**
     * @param array $inputArray
     * @dataProvider providerArray
     */
    public function testPop(array $inputArray){
        $count = count($inputArray) - 1;
        array_pop($inputArray);
        $this->assertEquals($count,count($inputArray));
    }

    /**
     * @param array $inputArray
     * @dataProvider providerArray
     */
    public function testSum(array $inputArray)
    {
        $expected = 0;
        for($i = 0; $i < count($inputArray); $i++){
            $expected += $inputArray[$i];
        }
        $this->assertEquals($expected,array_sum($inputArray));
    }
}
