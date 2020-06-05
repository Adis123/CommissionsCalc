<?php

namespace Tests;

class CountryTest extends \PHPUnit\Framework\TestCase
{
    public function testCountryIsEU(): void
    {
        $EUCountries =[
            'AT', 'BE', 'BG', 'CY', 'CZ', 'DE',
            'DK', 'EE', 'ES', 'FI', 'FR', 'GR',
            'HR', 'HU', 'IE', 'IT', 'LT', 'LU',
            'LV', 'MT', 'NL', 'PO', 'PT', 'RO',
            'SE', 'SI', 'SK',
        ];

        foreach ($EUCountries as $country) {
            $isEU = \App\isEuCountry($country);
            $this->assertTrue($isEU);
        }
    }

    public function testCountryIsNotEU(): void
    {
        $NonEUCountries =[
            'AR', 'UY', 'US',
        ];

        foreach ($NonEUCountries as $country) {
            $isEU = \App\isEuCountry($country);
            $this->assertFalse($isEU);
        }
    }
}
