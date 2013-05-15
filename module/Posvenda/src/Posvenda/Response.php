<?php

namespace Posvenda;

class Response
{
    private $_response;
    
    public function __construct(array $response)
    {
        if (array_key_exists('status', $response)) {
            $status = $response['status'];
        } else {
            $status = 200;
        }

        if (array_key_exists('result', $response)) {
            $result = $response['result'];
        } else {
            $result = $response;
        }

        $this->_response = new \Zend\Http\Response;
        $this->_response->setStatusCode($status);

        $headers = $this->_response->getHeaders();
		$headers->addHeaderLine('Content-Type', 'application/json');
		$this->_response->setHeaders($headers);

        $this->_response->setContent(\Zend\Json\Encoder::encode($result));

        return $this->_response;
    }

    public function getResponse()
    {
        return $this->_response;
    }
}
