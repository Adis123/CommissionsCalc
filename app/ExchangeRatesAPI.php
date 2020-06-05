<?php

namespace App;

class ExchangeRatesAPI implements ExchangeAPIInterface
{
    public function get()
    {
        return json_decode(file_get_contents('https://api.exchangeratesapi.io/latest'), true);
    }
}
