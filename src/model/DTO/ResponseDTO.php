<?php


class Response
{
    private $idUser;
    private $testName;
    private $responses;
    private $timestamp;

    public function __construct($json)
    {
        $this->idUser = $json->{"userId"};
        $this->testName = $json->{"testName"};
        $this->timestamp = $json->{"timestamp"};
        $this->responses = $json->{"responses"};
    }

    public function getIdUser()
    {
        return $this->idUser;
    }

    public function getTestName()
    {
        return $this->testName;
    }

    public function getResponses()
    {
        return $this->responses;
    }

    public function getTimestamp(){
        return $this->timestamp;
    }

}