<?php


class QuestionDTO implements JsonSerializable
{
    private $id;
    private $question;
    private $options = array();

    public function getQuestion()
    {
        return $this->question;
    }

    public function setQuestion($question)
    {
        $this->question = $question;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function setOptions(array $options)
    {
        $this->options = $options;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->id,
            "question" => $this->question,
            //"options" => $this->options
            "options" => $this->optionsToJSON()
        ];
    }

    private function optionsToJSON(){

        $options = array();

        foreach ($this->options as $key => $value){
            $option = array();
            $option["id"] = $key;
            $option["option"] = $value;
            array_push($options, $option);
        }

        return $options;
    }
}

