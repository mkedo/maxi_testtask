<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use MaxiTest\CurrencyBundle\RateSourceException;

/**
 * Parses rates xml from ecb.europa.eu https://www.ecb.europa.eu/stats/eurofxref/eurofxref-daily.xml
 */
class EcbEuroXmlRates
{
    /**
     * @var string
     */
    private $xmlString;

    /**
     * EcbEuropaEuXmlRates constructor.
     * @param string $xmlString the xml
     */
    public function __construct(string $xmlString)
    {
        if (empty($xmlString)) {
            throw new \InvalidArgumentException("xml can't be empty");
        }
        $this->xmlString = $xmlString;
    }

    /**
     * @return string how many rubles for one euro
     * @throws RateSourceException
     */
    public function getRubles(): string
    {
        $oldSetting = libxml_use_internal_errors(false);
        $xml = simplexml_load_string($this->xmlString);
        if ($xml === false) {
            libxml_use_internal_errors($oldSetting);
            throw new RateSourceException("Invalid xml: " . $this->xmlString);
        }
        libxml_use_internal_errors($oldSetting);

        $xml->registerXPathNamespace('c', 'http://www.ecb.int/vocabulary/2002-08-01/eurofxref');
        $currencies = $xml->xpath('//c:Cube[@currency="RUB"]');

        if ($currencies === false) {
            throw new RateSourceException("Cube tags not found");
        }

        foreach ($currencies as $node) {
            $attr = $node->attributes();
            if (!empty($attr['rate'])) {
                return (string)$attr['rate'];
            }
        }
        throw new RateSourceException("No RUB rate found");
    }
}
