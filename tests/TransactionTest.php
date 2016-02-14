<?php

namespace tests;

use util\FakeLogger;
use util\HttpClient;
use util\Transaction;

require_once('../util/ILogger.php');
require_once('../util/FakeLogger.php');
require_once('../util/HttpClient.php');
require_once('../util/Transaction.php');

class TransactionTest extends \PHPUnit_Framework_TestCase
{
    private $data;

    public function setUp()
    {
        $data = array('userId' => 1,'items' => [['id' => 1,'quantity' => 99]]);
        $this->data = $data;
    }

    public function testPrepareXmlRequest()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('\util\HttpClient',array(),array('http://localhost'));
        $transaction = new Transaction($logger,$client,$this->data);
        $request = new \SimpleXMLElement($transaction->prepareXmlRequest());
        $item = $request->items->item[0];
        $this->assertEquals(1,(int)$request['userId']);
        $this->assertEquals(1,(int)$item['id']);
        $this->assertEquals(99,(int)$item['quantity']);
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testPrepareXmlRequestFail()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('\util\HttpClient',array(),array('http://localhost'));
        unset($this->data['userId']);
        $transaction = new Transaction($logger,$client,$this->data);
        $request = $transaction->prepareXmlRequest();
    }

    public function testSendRequest()
    {
        $logger = new FakeLogger();
        $client = $this->getMock('\util\HttpClient',array('send'),array('http://localhost'));
        $client->expects($this->any())->method('send')->will($this->returnValue(true));
        $transaction = new Transaction($logger,$client,$this->data);
        $this->assertFalse($transaction->wasSent());
        $this->assertTrue($transaction->sendRequest());
        $this->assertTrue($transaction->wasSent());
    }
}
