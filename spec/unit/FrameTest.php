<?php

class FrameTest extends PHPUnit_Framework_TestCase
{
    public function testScoreOfAFrameWithTwoRollsWithScoreLessThan10()
    {
        $frame = new Frame();
        $frame->roll(2);
        $frame->roll(4);

        $this->assertEquals(6, $frame->score());
    }

    public function testIsCompleteReturnTrueOnlyAfterTwoRolls()
    {
        $frame = new Frame();
        $this->assertEquals(false, $frame->isComplete());
        $frame->roll(2);
        $this->assertEquals(false, $frame->isComplete());
        $frame->roll(4);

        $this->assertEquals(true, $frame->isComplete());
    }

    public function testIsCompleteReturnsTrueAfterASingleStrikeRoll()
    {
        $frame = new Frame();
        $this->assertEquals(false, $frame->isComplete());
        $frame->roll(10);
        $this->assertEquals(true, $frame->isComplete());
    }

    public function testIsStrikeReturnsTrueIfFirstRollIs10()
    {
        $frame = new Frame();
        $this->assertEquals(false, $frame->isStrike());
        $frame->roll(10);
        $this->assertEquals(true, $frame->isStrike());
    }

    public function testIsSpareReturnsTrueIfScoreIs10InTwoRolls()
    {
        $frame = new Frame();
        $this->assertEquals(false, $frame->isSpare());
        $frame->roll(8);
        $frame->roll(2);
        $this->assertEquals(true, $frame->isSpare());
    }

    public function testIsStrikeReturnsFalseIfIsSpare()
    {
        $frame = new Frame();
        $frame->roll(8);
        $frame->roll(2);
        $this->assertEquals(false, $frame->isStrike());
    }

    public function testIsSpareReturnsFalseIfIsStrike()
    {
        $frame = new Frame();
        $frame->roll(10);
        $this->assertEquals(false, $frame->isSpare());
    }

    public function testBonus()
    {
        $frame = new Frame();
        $frame->roll(10);
        $frame->roll(1);
        $frame->roll(7);
        /* $frame->bonus(1); */
        /* $frame->bonus(7); */
        $this->assertEquals(18, $frame->score());
    }

    public function testNeedBonus()
    {
        $frame = new Frame();
        $this->assertFalse($frame->needBonus());
        $frame->roll(10);
        $this->assertTrue($frame->needBonus());
        $frame->roll(2);
        $this->assertTrue($frame->needBonus());
        $frame->roll(3);
        $this->assertFalse($frame->needBonus());

        $frame = new Frame();
        $this->assertFalse($frame->needBonus());
        $frame->roll(5);
        $this->assertFalse($frame->needBonus());
        $frame->roll(5);
        $this->assertTrue($frame->needBonus());
        $frame->roll(2);
        $this->assertFalse($frame->needBonus());
    }
}
