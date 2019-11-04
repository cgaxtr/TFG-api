<?php

require_once __DIR__ . '/../config/DB.php';
require_once __DIR__ . '/../model/DTO/TestDTO.php';
require_once __DIR__ . '/../model/DTO/QuestionDTO.php';


class Test
{
    public static function getTestById($id){

        $conn = Db::getInstance()->getConnection();

        $stmt = $conn->prepare("SELECT questions.id, questions.question, test.name FROM questions, test_question, test WHERE test.id = test_question.id_test AND test_question.id_question = questions.id AND id_test = :id;");
        $stmt->bindParam(":id", $id,PDO::PARAM_INT);
        $stmt->execute();

        $test = null;
        $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($questions) != 0){
            $test = new TestDTO();
            $test->setName($questions[0]["name"]);

            $stmt = $conn->prepare("SELECT answers.id, answer FROM answers, questions_answers, questions WHERE answers.id = questions_answers.id_answer AND questions.id = questions_answers.id_question AND questions.id = :id ");

            for ($i = 0; $i < count($questions); $i++){
                $question = new QuestionDTO();
                $question->setId($questions[$i]["id"]);
                $question->setQuestion($questions[$i]["question"]);

                $stmt->bindParam(":id", $questions[$i]["id"],PDO::PARAM_INT);
                $stmt->execute();

                $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);

                if(count($answers) != 0){
                    //$options = array();
                    $options = array();
                    for ($j = 0; $j < count($answers); $j++){
                        //$options[$j] = $answers[$j]["answer"];
                        $options[$answers[$j]["id"]] = $answers[$j]["answer"];
                    }
                    //$question->setOptions($options);
                    $question->setOptions($options);
                }

                $test->addQuestion($question);
            }
        }

        return $test;
    }

    public static function getTestByName($name){

        $conn = Db::getInstance()->getConnection();
        $stmt = $conn->prepare("SELECT id FROM test WHERE name = :name");
        $stmt->bindParam(":name", $name,PDO::PARAM_STR);
        $stmt->execute();

        if($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            return Test::getTestById($row["id"]);
        }else{
            return null;
        }
    }

    public static function uploadResponseTest(Response $responses){

        $conn = Db::getInstance()->getConnection();

        $testName = $responses->getTestName();
        $idUser = $responses->getIdUser();
        $resp = $responses->getResponses();
        $date = date('Y-m-d h:i:s', $responses->getTimestamp());

        $stmt = $conn->prepare("INSERT INTO response (id_test, id_user, id_question, id_answer, date) VALUES ((SELECT id FROM test WHERE name = :test ), :user, :question, :answer, :date)");

        $conn->beginTransaction();

        try{
            $stmt->bindParam(":test", $testName,PDO::PARAM_STR);
            $stmt->bindParam(":user", $idUser,PDO::PARAM_INT);
            $stmt->bindParam(":date", $date,PDO::PARAM_STR);

            for($i = 0; $i < count($resp); $i++){
                $stmt->bindParam(":question", $resp[$i]->{"questionId"},PDO::PARAM_INT);
                $stmt->bindParam(":answer", $resp[$i]->{"responseId"},PDO::PARAM_INT);
                $stmt->execute();
            }
        } catch (PDOException $e){
            $conn->rollBack();
            return false;
        }

        $conn->commit();
        return true;
    }

    public static function getAvailableTestsForUser($id){
        $conn = Db::getInstance()->getConnection();
        $stmt = $conn->prepare("SELECT id, name FROM test WHERE id NOT IN (SELECT id_test FROM response WHERE id_user = :id AND date(date) = date(CURRENT_TIMESTAMP) GROUP BY id_test);");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);

        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $availableTests =  array();

        for($i = 0; $i < count($result); $i++){
            array_push($availableTests, $result[$i]["name"]);
        }

        return $availableTests;
    }

    public static function uploadNewTest(){

    }
}
