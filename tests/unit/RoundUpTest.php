<?php

namespace Tests;

class RoundUpTest extends \PHPUnit\Framework\TestCase
{
    public function testItRoundsUpWithPrecision3Places(): void
    {
        $result = \App\round_up(12.12345, 3);
        $this->assertEquals($result, 12.124);
    }

    public function testItRoundsUpWithPrecision2Places(): void
    {
        $result = \App\round_up(12.12345, 2);
        $this->assertEquals($result, 12.13);
    }

    public function testItRoundsUpWithPrecision1Place(): void
    {
        $result = \App\round_up(12.12345, 1);
        $this->assertEquals($result, 12.2);
    }
}
