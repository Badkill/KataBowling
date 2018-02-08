<?php

class Frame
{
    const STRIKE_SYBOL = 'X';
    const SPARE_SYMBOL = '/';
    const MISS_SYMBOL  = '-';

    private $rolls;
    private $isStrike;
    private $isSpare;

    public function __construct()
    {
        $this->rolls = [];
        $this->isStrike = false;
        $this->isSpare = false;
    }

    public function roll($score)
    {
        $score = $this->sanitize($score);
        $this->rolls[] = $score;

        if (10 == $score && (1 == $this->howManyRolls())) {
            $this->strike();
        } elseif (10 == $this->score() && 2 == $this->howManyRolls()) {
            $this->spare();
        }
    }

    public function score()
    {
        return array_sum($this->rolls);
    }

    public function isRoundCompleted()
    {
        return $this->isStrike() || 2 == $this->howManyRolls();
    }

    public function doesItNeedABonus()
    {
        if ($this->isStrike() || $this->isSpare()) {
            return $this->howManyRolls() < 3;
        }

        return false;
    }

    public function isStrike()
    {
        return $this->isStrike;
    }

    public function isSpare()
    {
        return $this->isSpare;
    }

    private function howManyRolls()
    {
        return count($this->rolls);
    }

    private function strike()
    {
        $this->isStrike = true;
    }

    private function spare()
    {
        $this->isSpare = true;
    }

    private function sanitize($score)
    {
        if (self::STRIKE_SYBOL === $score) {
            return 10;
        }

        if (self::SPARE_SYMBOL === $score) {
            return 10 - $this->rolls[count($this->rolls)-1];
        }

        if (self::MISS_SYMBOL === $score) {
            return 0;
        }

        return $score;
    }
}
