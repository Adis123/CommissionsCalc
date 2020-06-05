<?php

namespace Tests;

use App\ExchangeRatesAPI;

class CalcRateTest extends \PHPUnit\Framework\TestCase
{
    public function testItGetsRateForCurrencyEUR(): void
    {
        $value = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');

        $stub = $this->createStub(ExchangeRatesAPI::class);

        $stubResponse = $this->getStubResponse();

        $stub->method('get')->willReturn($stubResponse);

        $rate = \App\calc_rate($value, $stub);

        $this->assertIsFloat($rate);
    }

    public function testItGetsRateForCurrencyUSD(): void
    {
        $value = json_decode('{"bin":"516793","amount":"50.00","currency":"USD"}');

        $stub = $this->createStub(\App\ExchangeAPIInterface::class);

        $stubResponse = $this->getStubResponse();

        $stub->method('get')->willReturn($stubResponse);

        $rate = \App\calc_rate($value, $stub);

        $this->assertIsFloat($rate);
    }

    public function testItGetsRateForCurrencyJYPBaseUSD(): void
    {
        $value = json_decode('{"bin":"45417360","amount":"10000.00","currency":"JPY"}');

        $stub = $this->createStub(ExchangeRatesAPI::class);

        $stubResponse = $this->getStubResponse('usd');

        $stub->method('get')->willReturn($stubResponse);

        $rate = \App\calc_rate($value, $stub);

        $this->assertIsFloat($rate);
    }

    public function testItGetsRateForCurrencyEURBaseUSD(): void
    {
        $value = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');

        $stub = $this->createStub(ExchangeRatesAPI::class);

        $stubResponse = $this->getStubResponse('usd');

        $stub->method('get')->willReturn($stubResponse);

        $rate = \App\calc_rate($value, $stub);

        $this->assertIsFloat($rate);
    }

    public function testItGetsInvalidResponse(): void
    {
        $value = json_decode('{"bin":"45717360","amount":"100.00","currency":"EUR"}');

        $this->expectException(\Exception::class);

        $stub = $this->createStub(ExchangeRatesAPI::class);

        $stub->method('get')->willReturn(false);

        $rate = \App\calc_rate($value, $stub);

        $this->assertFalse($rate);
    }

    protected function getStubResponse($base = 'eur')
    {
        return json_decode(file_get_contents(__DIR__.'/stubs/rates-response-base-'.$base.'.json'), true);
    }
}
