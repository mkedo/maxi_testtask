<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use MaxiTest\CurrencyBundle\EuroRateSource;
use MaxiTest\CurrencyBundle\RateSourceException;

class CbrEuro implements EuroRateSource
{
    /**
     * @var string
     */
    private $url = 'http://www.cbr-xml-daily.ru/daily_json.js';

    /**
     * @return string how much rubles for one euro
     * @throws RateSourceException
     */
    public function getRubles(): string
    {
        $content = (new HttpGetRequest($this->url))->getContent();
        $rate = new CbrEuroJsonRates($content);
        return $rate->getRubles();
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return "Russian Central Bank proxy";
    }
}
