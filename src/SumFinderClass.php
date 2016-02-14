<?php

namespace src;

/**
 * Class SumFinderClass
 */

class SumFinderClass
{
    private $arr;

    /**
     * SumFinderClass constructor.
     * @param null $inputArr
     */
    public function __construct($inputArr = null){
        $this->arr = $inputArr;
    }

    /**
     * Returns sum of the largest group of contiguous numbers
     * @return int
     */
    public function findSum(){
        $arrayGroups = array();
        foreach($this->arr as $element){
            if(!isset($previousElement)){
                $previousElement = $element;
                $arrayGroupNumber = 0;
            }
            if(($previousElement + 1) != $element){
                $arrayGroupNumber += 1;
            }
            $arrayGroups[$arrayGroupNumber][] = $element;
            $previousElement = $element;
        }
        usort($arrayGroups,array($this,'compareArrays'));
        $highestGroup = array_pop($arrayGroups);
        return $this->extractResult($highestGroup);
    }

    /**
     * Custom compare arrays method
     * @param array $a
     * @param array $b
     * @return int
     */
    public function compareArrays(array $a,array $b){
        $sumA = array_sum($a);
        $sumB = array_sum($b);
        if($sumA == $sumB){
            return 0;
        }elseif($sumA> $sumB){
            return 1;
        }else{
            return -1;
        }
    }

    /**
     * Extracts result as a specified array from an input array
     * @param array $highestGroup
     * @return array|bool
     */
    private function extractResult($highestGroup){
        if(!$highestGroup || !is_array($highestGroup))
            return false;
        $groupName = implode(',',$highestGroup);
        $groupSum = array_sum($highestGroup);
        return array('group' => $groupName,'sum' => $groupSum);
    }
}