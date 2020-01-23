<?php


class MeasurementDTO implements JsonSerializable
{
    private $idUser;
    private $type;
    private $value;
    private $timestamp;



    /*
    public function __construct($json, $type)
    {
        $this->idUser = $json->{'idUser'};
        $this->type = $type;
        $this->value = $json->{'value'};
        $this->timestamp = $json->{'timestamp'};
    }
    */

    public function __construct($idUser, $type, $value, $timestamp)
    {
        $this->idUser = $idUser;
        $this->type = $type;
        $this->value = $value;
        $this->timestamp = $timestamp;
    }

    public function getId(): int
    {
        return $this->idUser;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getType()
    {
        return $this->type;
    }

    public function setType($type): void
    {
        $this->type = $type;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function setValue($value): void
    {
        $this->value = $value;
    }

    public function getTimestamp()
    {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;
    }



    public function jsonSerialize()
    {
        return [
            "idUser" => $this->idUser,
            "value" => $this->value,
            "timestamp" => $this->timestamp
        ];
    }

}