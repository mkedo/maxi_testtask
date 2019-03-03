<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
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
        $client = new Client([
            'timeout' => 2.0,
        ]);

        try {
            $response = $client->request('GET', $this->url);
        } catch (GuzzleException $e) {
            throw new RateSourceException("Request failed:" . $e->getMessage());
        }

        $statusCode = $response->getStatusCode();
        if ($statusCode !== 200) {
            throw new RateSourceException("Wrong status code " . $statusCode);
        }
        $content = $response->getBody()->getContents();
        if (empty($content)) {
            throw new RateSourceException("Empty body ");
        }
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
