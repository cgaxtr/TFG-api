<?php

require_once __DIR__ . '/../config/DB.php';

class Measurement
{

    public static function uploadMeasure(MeasurementDTO $measure){
        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("INSERT INTO measures (id_user, type, value, date) VALUES (:id, :type, :value, :date);");

        $stmt->bindValue(":id", $measure->getId(),PDO::PARAM_INT);
        $stmt->bindValue(":type", $measure->getType(),PDO::PARAM_STR);
        $stmt->bindValue(":value", $measure->getValue(),PDO::PARAM_INT);
        $stmt->bindValue(":date", date("Y-m-d H:i:s", $measure->getTimestamp()));

        $stmt->execute();

        if ($stmt->rowCount() == 0){
            return false;
        }else{
            return true;
        }
    }


    public static function getMeasure($idUser, $type){
        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT * FROM measures WHERE id_user = :id AND type = :type;");
        $stmt->bindParam(":id", $idUser,PDO::PARAM_INT);
        $stmt->bindParam(":type", $type,PDO::PARAM_STR);

        $stmt->execute();

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $measures = array();

        for($i = 0; $i < count($rows); $i++){
            $measures[$i] = new MeasurementDTO($rows[$i]["id_user"], $rows[$i]["type"], $rows[$i]["value"], strtotime($rows[$i]["date"]));
        }

        return $measures;
    }
}