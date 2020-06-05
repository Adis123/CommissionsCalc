<?php

namespace App;

use App\BinAPIInterface;
use App\ExchangeAPIInterface;
use App\ExchangeRatesAPI;

/**
 * Determine if BIN is EU
 *
 * @param stdClass $value [description]
 *
 * @return boolean        Is EU
 */
function isEuCountry($country)
{
    switch ($country) {
    case 'AT':
    case 'BE':
    case 'BG':
    case 'CY':
    case 'CZ':
    case 'DE':
    case 'DK':
    case 'EE':
    case 'ES':
    case 'FI':
    case 'FR':
    case 'GR':
    case 'HR':
    case 'HU':
    case 'IE':
    case 'IT':
    case 'LT':
    case 'LU':
    case 'LV':
    case 'MT':
    case 'NL':
    case 'PO':
    case 'PT':
    case 'RO':
    case 'SE':
    case 'SI':
    case 'SK':
        $result = true;
        return $result;
    default:
        $result = false;
    }

    return $result;
}

/**
 * Determine if BIN is EU
 *
 * @param stdClass $value [description]
 * @param \App\BinAPIInterface $BinList [description]
 *
 * @return boolean        Is EU
 */
function isBinEu($value, BinAPIInterface $BinList)
{
    $binResults = $BinList->getBinResults($value->bin);

    return isEuCountry($binResults->country->alpha2);
}

/**
 * Get the latest rates from remote source exchangeratesapi
 *
 * @param string $currency Currency to get
 * @param \App\ExchangeRatesAPI $exchangeRatesAPI API Client
 *
 * @return [type]           [description]
 */
function getLatestRates(string $currency, ExchangeAPIInterface $exchangeRatesAPI)
{
    $response = $exchangeRatesAPI->get();
    if (!is_array($response)) {
        return false;
    }

    if (!array_key_exists($currency, $response['rates'])) {
        if ($currency == "EUR") {
            return floatval(0);
        }
        return false;
    }



    return $response['rates'][$currency];
}

function calc_rate($value, ExchangeAPIInterface $exchangeRatesAPI)
{
    $rate = getLatestRates($value->currency, $exchangeRatesAPI);

    if ($rate === false) {
        throw new \Exception("Currency Not Found", 1);
    }

    if ($value->currency == 'EUR' or $rate == 0) {
        return floatval($value->amount);
    }

    return $value->amount / $rate;
}

function round_up($value, $precision)
{
    $pow = pow(10, $precision);
    return (ceil($pow * $value) + ceil($pow * $value - ceil($pow * $value))) / $pow;
}
