<?php

namespace MaxiTest\CurrencyBundle\Tests\RateSource;

use MaxiTest\CurrencyBundle\RateSource\CbrEuroJsonRates;

class CbrEuroJsonRatesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRubles()
    {
        $rates = new CbrEuroJsonRates(file_get_contents(__DIR__ . '/daily_json.js.json'));
        $this->assertSame('74.9691', $rates->getRubles());
    }
}
