<?php
class Bowling
{
    // current round number
    private $round;

    // list of all started frames
    private $frames;

    public function __construct()
    {
        $frame = new Frame();
        $this->frames = [$frame];
        $this->round = 0;
    }

    public static function fromACompletedGameScores($scoresRid)
    {
        $scores = str_split(str_replace(' ', '', $scoresRid));

        $game = new Bowling();
        foreach ($scores as $score) {
            $game->roll($score);
        }

        return $game;
    }

    public function roll($score)
    {
        $this->assignBonusToPreviousRounds($score);

        if ($this->allRoundsArePlayed()) {
            return;
        }

        $this->frames[$this->round]->roll($score);

        if ($this->frames[$this->round]->isRoundCompleted()) {
            $this->nextRound();
        }
    }

    private function nextRound()
    {
        $this->round++;
        $this->frames[$this->round] = new Frame();
    }

    public function score()
    {
        return array_reduce($this->frames, function($carry, $frame) {
            return $carry + $frame->score();
        });
    }

    private function assignBonusToPreviousRounds($score)
    {
        foreach ($this->frames as $frame) {
            if ($frame->doesItNeedABonus()) {
                $frame->roll($score);
            }
        }
    }

    private function allRoundsArePlayed()
    {
        return 10 == $this->round;
    }
}
