<?php

class BowlingGame
{
    private $frame = [];
    private $currentFrame;
    private $maxFrame;

    public function __construct($maxFrame)
    {
        for($i = 0; $i < $maxFrame; $i++) {
            $this->frame[$i] = new Frame();
        }

        $this->currentFrame = 0;
        $this->maxFrame = $maxFrame;
    }

    public function roll($pin)
    {
        $this->assignBonusToPreviousFrame($pin);

        if ($this->isBonusOfLastFrame()) {
            return;
        }

        $this->frame[$this->currentFrame]->roll($pin);

        if ($this->frame[$this->currentFrame]->isComplete()) {
            $this->currentFrame++;
        }
    }

    public function score()
    {
        $score = 0;
        for($i = 0; $i < $this->maxFrame; $i++) {
            $score += $this->frame[$i]->score();
        }

        return $score;
    }

    private function assignBonusToPreviousFrame($bonus)
    {
        for($i = $this->currentFrame - 1; $i >= 0; $i--) {
            if ($this->frame[$i]->needBonus()) {
                $this->frame[$i]->bonus($bonus);
            } else {
                break;
            }
        }
    }

    private function isBonusOfLastFrame()
    {
        return $this->currentFrame == $this->maxFrame;
    }
}
