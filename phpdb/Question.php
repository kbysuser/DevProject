<?php

class Question
{
    public $text;
    public $choices;
    public $answer;
    public function __construct($text, $choices, $answer)
    {
        $this->text = $text;
        $this->choices = $choices;
        $this->answer = $answer;
    }
}

?>