<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use MaxiTest\CurrencyBundle\EuroRateSource;
use MaxiTest\CurrencyBundle\RateSourceException;

class EcbEuro implements EuroRateSource
{
    private $url = 'https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml';

    /**
     * @return string how much rubles for one euro
     * @throws RateSourceException
     */
    public function getRubles(): string
    {
        $content = (new HttpGetRequest($this->url))->getContent();
        $xmlRates = new EcbEuroXmlRates($content);
        return $xmlRates->getRubles();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return "European Central Bank";
    }
}
