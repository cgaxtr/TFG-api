<?php

class UserDTO implements JsonSerializable{

    private  $id;
    private $role;
    private $name;
    private $surname;
    private $birthdate;
    private $email;
    private $pass;

    public function __construct($id, $role, $name, $surname, $email, $birthdate,  $pass)
    {
        $this->id = $id;
        $this->role = $role;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->birthdate = $birthdate;
        $this->pass = $pass;

    }


    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;
    }

    public function getPass()
    {
        return $this->pass;
    }

    public function setPass($pass)
    {
        $this->pass = $pass;
    }

    public function getSurname()
    {
        return $this->surname;
    }

    public function setSurname($surname)
    {
        $this->surname = $surname;
    }

    public function getBirthdate()
    {
        return $this->birthdate;
    }

    public function setBirthdate($birthdate)
    {
        $this->birthdate = $birthdate;
    }



    public function jsonSerialize(){
        return [
            "id" => $this->id,
            "role" => $this->role,
            "name" => $this->name,
            "surname" => $this->surname,
            "email" => $this->email,
            "birthdate" => $this->birthdate,
        ];
    }
}