<?php

class Frame
{
    private $rolls = [];
    private $bonus = [];

    public function __construct()
    {
    }

    public function roll($pin)
    {
        if (2 === count($this->rolls)) {
            return $this->bonus($pin);
        }

        $this->rolls[] = $pin;

        if (10 === $pin) {
            $this->rolls[] = 0;
        }
    }

    public function score()
    {
        return array_sum($this->rolls) + array_sum($this->bonus);
    }

    public function isComplete()
    {
        return 2 === count($this->rolls) || $this->isStrike();
    }

    public function isStrike()
    {
        return
            1 < count($this->rolls) &&
            10 === $this->rolls[0]
        ;
    }

    public function isSpare()
    {
        return
            2 === count($this->rolls) &&
            10 === $this->rolls[0] + $this->rolls[1] &&
            !$this->isStrike()
        ;
    }

    public function bonus($bonus)
    {
        $this->bonus[] = $bonus;
    }

    public function needBonus()
    {
        if (
            ($this->isStrike() && 2 > count($this->bonus)) ||
            ($this->isSpare() && 1 > count($this->bonus))
        ) {
            return true;
        }

        return false;
    }
}
