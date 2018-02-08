<?php

class BowlingTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->game = new Bowling();
    }

    public function testTakeARoll()
    {
        $this->game->roll(3);
        $this->assertEquals(3, $this->game->score());
    }

    public function testAllZeros()
    {
        $this->takeRolls(20, 0);
        $this->assertEquals(0, $this->game->score());
    }

    public function testAllOne()
    {
        $this->takeRolls(20, 1);
        $this->assertEquals(20, $this->game->score());
    }

    public function testAllStrike()
    {
        $this->takeRolls(12, 'X');
        $this->assertEquals(300, $this->game->score());
    }

    public function testAllSpare()
    {
        $this->takeRolls(21, 5);
        $this->assertEquals(150, $this->game->score());
    }

    public function testMixOfSpareStrikeAndSimple()
    {
        $game = Bowling::fromACompletedGameScores('X 42 63 9/ X 52 81 X 7/ 6/5');
        $this->assertEquals(135, $game->score());
    }

    public function testTenPairsOf9AndMiss()
    {
        $game = Bowling::fromACompletedGameScores('9- 9- 9- 9- 9- 9- 9- 9- 9- 9-');
        $this->assertEquals(90, $game->score());
    }

    private function takeRolls($howMany, $score)
    {
        for ($i = 0; $i < $howMany; $i++) {
            $this->game->roll($score);
        }
    }
}
