<?php

require_once __DIR__ . '/../config/DB.php';
require_once __DIR__ . '/../model/DTO/UserDTO.php';

class User{

    public static function login($email, $password){

        $conn = Db::getInstance()->getConnection();
        $hash = hash("sha256", $password);

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email AND pass = :pass");
        $stmt->bindParam(":email", $email,PDO::PARAM_STR);
        $stmt->bindParam(":pass", $hash, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){

            $usu = new UserDTO($row["id"], $row["role"], $row["name"], $row["surname"], $row["email"], strtotime($row["birthdate"]),null);

            return $usu;
        }else {
            return null;
        }
    }

    public static function register(UserDTO $user){

        $conn = Db::getInstance()->getConnection();

        $hash = hash("sha256", $user->getPass());
        $stmt = $conn->prepare("INSERT INTO users (role, name, surname, email, birthdate, pass) VALUES (:role, :name, :surname, :email, :birthdate, :pass)");
        $stmt->bindValue(":role", $user->getRole(),PDO::PARAM_STR);
        $stmt->bindValue(":name", $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":surname", $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":birthdate", date('Y-m-d', $user->getBirthdate()));
        $stmt->bindValue(":pass", $hash, PDO::PARAM_STR);

        $stmt->execute();

        return $conn->lastInsertId();
    }

    public static function getUserById($id){

        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->bindParam(":id", $id,PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            $usu = new UserDTO($row["id"], $row["role"], $row["name"], $row["surname"], $row["email"], strtotime($row["birthdate"]),null);
            return $usu;
        }else {
            return null;
        }

    }

    public static function getUserByEmail($email){
        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(":email", $email,PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row){
            $usu = new UserDTO($row["id"], $row["role"], $row["name"], $row["surname"], $row["email"], strtotime($row["birthdate"]),null);
            return $usu;
        }else {
            return null;
        }
    }

    public static function getAllUsers(){

        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM users");
        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $users = array();

        for($i = 0; $i < count($rows); $i++){
            $users[$i] = new UserDTO($rows[$i]["id"], $rows[$i]["role"], $rows[$i]["name"], $rows[$i]["surname"], $rows[$i]["email"], strtotime($rows[$i]["birthdate"]),"");
        }

        return $users;
    }

    public static function updateUser(UserDTO $user){
        $conn = Db::getInstance()->getConnection();
        $stmt = $conn->prepare("UPDATE users SET name = :name, surname = :surname, email = :email, birthdate = :date WHERE id = :id;");

        $stmt->bindValue(":name", $user->getName(), PDO::PARAM_STR);
        $stmt->bindValue(":surname", $user->getSurname(), PDO::PARAM_STR);
        $stmt->bindValue(":email", $user->getEmail(), PDO::PARAM_STR);
        $stmt->bindValue(":date", date('Y-m-d', $user->getBirthdate()));
        $stmt->bindValue(":id", $user->getId(), PDO::PARAM_INT);

        $stmt->execute();

        $count = $stmt->rowCount();

        if ($count == 1){
            return User::getUserById($user->getId());
        }else{
            return null;
        }
    }
}