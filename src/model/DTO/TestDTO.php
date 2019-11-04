<?php


class TestDTO implements JsonSerializable{

    private $name;
    private $questions = array();

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getQuestions(): array
    {
        return $this->questions;
    }

    public function addQuestion(QuestionDTO $question){
        array_push($this->questions, $question);
    }

    public function jsonSerialize()
    {
        return [
            "name" => $this->name,
            "questions" => $this->questions,
        ];
    }
}