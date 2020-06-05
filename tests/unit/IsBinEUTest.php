<?php

namespace Tests;

use App\BinList;

class IsBinEUTest extends \PHPUnit\Framework\TestCase
{
    public function testIsBinEU(): void
    {
        $value = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');

        $stub = $this->createStub(\App\BinAPIInterface::class);

        //$stubResponse = $this->getStubResponse();
        $stubResponse = $this->getStubResponse($value->bin);

        $stub->method('getBinResults')->with($value->bin)->willReturn($stubResponse);

        $isEU = \App\isBinEu($value, $stub);

        $this->assertTrue($isEU);
    }

    public function testIsBinNotEU(): void
    {
        $value = json_decode('{"bin":"516793","amount":"50.00","currency":"USD"}');

        $stub = $this->createStub(\App\BinAPIInterface::class);

        //$stubResponse = $this->getStubResponse();
        $stubResponse = $this->getStubResponse($value->bin);

        $stub->method('getBinResults')->with($value->bin)->willReturn($stubResponse);

        $isEU = \App\isBinEu($value, $stub);

        $this->assertTrue($isEU);
    }

    protected function getStubResponse($bin)
    {
        return json_decode(file_get_contents(__DIR__.'/stubs/bins/'.$bin.'.json'));
    }
}
