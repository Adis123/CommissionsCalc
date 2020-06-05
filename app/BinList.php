<?php

namespace App;

use App\BinAPIInterface;

class BinList implements BinAPIInterface
{
    public function getBinResults(string $bin)
    {
        $binResults = file_get_contents('https://lookup.binlist.net/' .$bin);

        if (!$binResults) {
            throw new Exception("Error! bin api broken");
        }

        return json_decode($binResults);
    }
}
