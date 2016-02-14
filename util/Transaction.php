<?php

namespace util;


class Transaction
{
    private $logger;
    private $client;
    private $data;
    private $response;

    /**
     * Transaction constructor.
     * @param ILogger $logger
     * @param HttpClient $client
     * @param array $data
     */
    public function __construct(ILogger $logger, HttpClient $client, array $data)
    {
        $this->logger = $logger;
        $this->client = $client;
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function prepareXmlRequest()
    {
        if(!isset($this->data['userId'])){
            throw new \InvalidArgumentException('Missing userid');
        }
        if(!isset($this->data['items']) || !is_array($this->data['items'])){
            throw new \InvalidArgumentException('Missing data items');
        }

        $requestXml = new \SimpleXMLElement('<request></request>');
        $requestXml->addAttribute('userId', $this->data['userId']);
        $itemsXml = $requestXml->addChild('items');

        foreach($this->data['items'] as $item){
            $itemXml = $itemsXml->addChild('item');
            $itemXml->addAttribute('id',$item['id']);
            $itemXml->addAttribute('quantity',$item['quantity']);
        }

        return $requestXml->asXML();
    }

    /**
     * @return bool
     */
    public function sendRequest()
    {
        $request = $this->prepareXmlRequest();
        $this->client->setRequest($request);
        $this->logger->log($request,ILogger::PRIORITY_INFO);
        $this->response = $this->client->send();
        return $this->response;
    }

    /**
     * @return bool
     */
    public function wasSent()
    {
        return !empty($this->response);
    }
}