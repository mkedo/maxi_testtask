<?php

namespace MaxiTest\CurrencyBundle\RateSource;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use MaxiTest\CurrencyBundle\RateSourceException;

class HttpGetRequest
{
    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     * @throws RateSourceException
     */
    public function getContent(): string
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
            throw new RateSourceException("Empty body");
        }
        return $content;
    }
}
