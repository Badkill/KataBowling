<?php

class FrameTest extends \PHPUnit_Framework_TestCase
{
    public function testTakeASingleRoll()
    {
        $frame = new Frame();
        $frame->roll(3);
        $this->assertEquals(3, $frame->score());
        $this->assertFalse($frame->isRoundCompleted());
    }

    public function testTakeTwoRollsAndCompleteTheFrame()
    {
        $frame = new Frame();
        $frame->roll(3);
        $frame->roll(4);
        $this->assertEquals(7, $frame->score());
        $this->assertTrue($frame->isRoundCompleted());
    }

    public function testCompletedFrameWithLessThan10PinsDownIsNeitherAStrikeNorASpare()
    {
        $frame = new Frame();
        $frame->roll(3);
        $frame->roll(4);

        $this->assertIsASimpleFrame($frame);
    }

    public function testAStrike()
    {
        $frame = new Frame();
        $frame->roll(10);

        $this->assertEquals(10, $frame->score());
        $this->assertTrue($frame->isStrike());
        $this->assertFalse($frame->isSpare());

        $this->assertTrue($frame->isRoundCompleted());
        $this->assertTrue($frame->doesItNeedABonus());
    }

    public function testASpare()
    {
        $frame = new Frame();
        $frame->roll(5);
        $frame->roll(5);

        $this->assertEquals(10, $frame->score());
        $this->assertFalse($frame->isStrike());
        $this->assertTrue($frame->isSpare());

        $this->assertTrue($frame->isRoundCompleted());
        $this->assertTrue($frame->doesItNeedABonus());
    }

    public function testAStrikeFrameAcceptsTwoBonusRolls()
    {
        $frame = new Frame();
        $frame->roll(10);
        $this->assertTrue($frame->doesItNeedABonus());

        $frame->roll(3);
        $this->assertTrue($frame->doesItNeedABonus());

        $frame->roll(4);
        $this->assertFalse($frame->doesItNeedABonus());

        $this->assertEquals(17, $frame->score());
    }

    public function testASpareFrameAcceptsABounsRoll()
    {
        $frame = new Frame();
        $frame->roll(5);
        $frame->roll(5);
        $this->assertTrue($frame->doesItNeedABonus());

        $frame->roll(3);
        $this->assertFalse($frame->doesItNeedABonus());

        $this->assertEquals(13, $frame->score());
    }

    public function testAMissingRoll()
    {
        $frame = new Frame();
        $frame->roll(5);
        $frame->roll(0);

        $this->assertEquals(5, $frame->score());
        $this->assertTrue($frame->isRoundCompleted());

        $this->assertIsASimpleFrame($frame);
    }

    public function testDoubleMissingRolls()
    {
        $frame = new Frame();
        $frame->roll(0);
        $frame->roll(0);

        $this->assertEquals(0, $frame->score());
        $this->assertTrue($frame->isRoundCompleted());

        $this->assertIsASimpleFrame($frame);
    }

    public function testScoreAcceptsAlsoCharacterRapresentation()
    {
        $frame = new Frame();
        $frame->roll('X');
        $this->assertTrue($frame->isStrike());

        $frame = new Frame();
        $frame->roll('4');
        $frame->roll('/');
        $this->assertEquals(10, $frame->score());
        $this->assertTrue($frame->isSpare());

        $frame = new Frame();
        $frame->roll('6');
        $frame->roll('-');
        $this->assertEquals(6, $frame->score());

        $frame = new Frame();
        $frame->roll('X');
        $frame->roll('3');
        $frame->roll('/');
        $this->assertEquals(20, $frame->score());
    }

    private function assertIsASimpleFrame($frame)
    {
        $this->assertFalse($frame->isStrike());
        $this->assertFalse($frame->isSpare());
    }
}
