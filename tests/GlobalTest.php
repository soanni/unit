<?php

namespace tests;

/**
 * Class GlobalTest
 * @package tests
 * @backupGlobals enabled
 */
class GlobalTest extends \PHPUnit_Framework_TestCase
{
    public static function setUpBeforeClass()
    {
        $config = new \stdClass();
        $config->date = new \DateTime('today');
        $GLOBALS['config'] = $config;
    }

    public function testToday()
    {
        $today = new \DateTime('today');
        $this->assertEquals($today,$GLOBALS['config']->date);
        $GLOBALS['config']->date = new \DateTime('tomorrow');
    }

    /**
     * @backupGlobals disabled
     */
    public function testTomorrow()
    {
        $tomorrow = new \DateTime('tomorrow');
        $this->assertTrue($tomorrow > $GLOBALS['config']->date);
        $GLOBALS['config']->date = $tomorrow;
    }

    public function testTomorrowIsolated()
    {
        $tomorrow = new \DateTime('tomorrow');
        $this->assertEquals($tomorrow,$GLOBALS['config']->date);
    }
}
