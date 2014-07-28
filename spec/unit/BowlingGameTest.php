<?php

class BowlingGameTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this->bowlingGame = new BowlingGame(10);
    }

    public function testScoreAfterAFrameWhereNotAllPinsComeDown()
    {
        $this->bowlingGame->roll(2);
        $this->bowlingGame->roll(4);

        $this->assertEquals(6, $this->bowlingGame->score());
    }

    public function testScoreAfterTwoFrameWhereNotAllPinsComeDown()
    {
        $this->bowlingGame->roll(2);
        $this->bowlingGame->roll(4);

        $this->bowlingGame->roll(1);
        $this->bowlingGame->roll(7);

        $this->assertEquals(14, $this->bowlingGame->score());
    }

    public function testScoreAfterASpare()
    {
        $this->bowlingGame->roll(2);
        $this->bowlingGame->roll(8);

        $this->bowlingGame->roll(1);
        $this->bowlingGame->roll(7);

        $this->assertEquals(19, $this->bowlingGame->score());
    }

    public function testScoreAfterAStrike()
    {
        $this->bowlingGame->roll(10);

        $this->bowlingGame->roll(1);
        $this->bowlingGame->roll(7);

        $this->assertEquals(26, $this->bowlingGame->score());
    }

    public function testPartialGame()
    {
        $this->bowlingGame->roll(1);
        $this->bowlingGame->roll(4);
        $this->bowlingGame->roll(4);
        $this->bowlingGame->roll(5);
        $this->bowlingGame->roll(6);
        $this->bowlingGame->roll(4);
        $this->bowlingGame->roll(5);
        $this->bowlingGame->roll(5);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(0);
        $this->bowlingGame->roll(1);
        $this->bowlingGame->roll(7);
        $this->bowlingGame->roll(3);
        $this->bowlingGame->roll(6);
        $this->bowlingGame->roll(4);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(2);
        $this->bowlingGame->roll(8);
        $this->bowlingGame->roll(6);

        $this->assertEquals(133, $this->bowlingGame->score());
    }

    public function testPerfectGame()
    {
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);
        $this->bowlingGame->roll(10);

        $this->assertEquals(300, $this->bowlingGame->score());
    }
}
