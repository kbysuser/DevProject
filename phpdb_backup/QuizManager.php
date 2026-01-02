<?php
class QuizManager
{
    private $questions = [];
    private $currentQuestionIndex = 0;
    public const STATE_QUESTION = 1;
    public const STATE_INCORRECT = 2;
    public const STATE_CORRECT = 3;
    public const STATE_END=4;
    public function __construct()
    {
        $this->questions = [
            new Question(
                "ランサムウェアの侵入経路で一番多いのは？",
                ["VPN機器", "WordPress", "リモートデスクトップ"],
                0
            ),
            new Question(
                "入力フォーム等に不正なコードを入れて、
                サーバのデータを窃み取ったり改ざんするのは？",
                ["Dos攻撃", "インジェクション攻撃", "ショルダーハッキング"],
                1
            )
        ];
    }
    public function getCurrentQuestionIndex()
    {
        return $this->currentQuestionIndex;
    }
    public function getCurrentQuestion()
    {
        return $this->questions[$this->currentQuestionIndex];
    }
    public function checkAnswer($userAnswer)
    {
        $currentQuestion = $this->getCurrentQuestion();
        return $userAnswer == $currentQuestion->answer;
    }
    public function nextQuestion()
    {
        $this->currentQuestionIndex++;
        if ($this->currentQuestionIndex >= count($this->questions)) {
            $this->currentQuestionIndex = 0;
        }
    }
    public function isLastQuestion()
    {
        return $this->currentQuestionIndex === count($this->questions)-1;
    }

}

?>