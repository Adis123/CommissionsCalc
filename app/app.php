<?php

namespace App;

require_once __DIR__.'/../vendor/autoload.php';

use App\BinList;
use App\ExchangeRatesAPI;

foreach (explode("\n", file_get_contents($argv[1])) as $row) {
    if (empty($row)) {
        break;
    }

    $value = json_decode($row);

    $isEu = isBinEu($value, new BinList);

    $amntFixed = calc_rate($value, new ExchangeRatesAPI);

    $amntCnv = $amntFixed * ($isEu == true ? 0.01 : 0.02);
    echo(round_up($amntCnv, 2) . "\n");
}
