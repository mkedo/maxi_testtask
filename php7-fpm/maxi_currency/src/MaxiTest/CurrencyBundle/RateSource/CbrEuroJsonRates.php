<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use MaxiTest\CurrencyBundle\RateSourceException;

/**
 * Parses json http://www.cbr-xml-daily.ru/daily_json.js
 */
class CbrEuroJsonRates
{
    /**
     * @var string
     */
    private $jsonString;

    /**
     * CbrEuroJsonRates constructor.
     * @param string $jsonString
     */
    public function __construct(string $jsonString)
    {
        if (empty($jsonString)) {
            throw new \InvalidArgumentException("json can't be empty");
        }
        $this->jsonString = $jsonString;
    }

    /**
     * How many rubles for one euro.
     * @return string
     * @throws RateSourceException
     */
    public function getRubles(): string
    {
        $rates = json_decode($this->jsonString, true);
        if ($rates === null) {
            throw new RateSourceException("Invalid json:" . $this->jsonString);
        }
        if (isset($rates["Valute"]["EUR"]["Value"])) {
            return (string)$rates["Valute"]["EUR"]["Value"];
        }
        throw new RateSourceException("No RUB rate");
    }
}
