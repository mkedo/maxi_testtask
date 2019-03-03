<?php

namespace MaxiTest\CurrencyBundle\Tests\RateSource;

use MaxiTest\CurrencyBundle\RateSource\EcbEuroXmlRates;

class EcbEuroXmlRatesTest extends \PHPUnit_Framework_TestCase
{
    public function testGetRubles()
    {
        $rates = new EcbEuroXmlRates(file_get_contents(__DIR__ . '/eurofxref-daily.xml'));
        $this->assertSame('75.0888', $rates->getRubles());
    }
}
