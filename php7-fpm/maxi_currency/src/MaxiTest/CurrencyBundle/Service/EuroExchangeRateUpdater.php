<?php

namespace MaxiTest\CurrencyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MaxiTest\CurrencyBundle\Entity\CurrencyRate;
use MaxiTest\CurrencyBundle\EuroRateSource;
use MaxiTest\CurrencyBundle\RateSourceException;
use Psr\Log\LoggerInterface;

class EuroExchangeRateUpdater
{
    /**
     * @var EntityManagerInterface
     */
    private $em;
    /**
     * @var EuroRateSource[]
     */
    private $sources;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * EuroRate constructor.
     * @param EuroRateSource[] $sources
     * @param EntityManagerInterface $em
     * @param LoggerInterface $logger
     */
    public function __construct(array $sources, EntityManagerInterface $em, LoggerInterface $logger)
    {
        $this->em = $em;
        $this->sources = $sources;
        $this->logger = $logger;
    }

    /**
     * Updates EURO rate from the sources.
     */
    public function update(): void
    {
        $rubles = $this->getRubles();

        $em = $this->em;
        $repository = $em->getRepository(CurrencyRate::class);
        /**
         * @var $rate CurrencyRate
         */
        $rate = $repository->findOneBy(['code' => "EUR"]);
        if (!isset($rate)) {
            $rate = new CurrencyRate();
            $rate->setCode("EUR");
            $rate->setRubles($rubles);
            $em->persist($rate);
        } else {
            $rate->setRubles($rubles);
        }
        $em->flush();
    }

    /**
     * @return string
     * @throws RateSourceException
     */
    private function getRubles(): string
    {
        // iterate over sources until one succeed
        foreach ($this->sources as $source) {
            /**
             * @var $source EuroRateSource
             */
            try {
                $this->logger->info("Trying to get exchange rate from {sourceName}", [
                    'sourceName' => $source->getName()
                ]);

                $rubles = $source->getRubles();

                $this->logger->info("Got exchange rate from {sourceName}", [
                    'sourceName' => $source->getName()
                ]);
                return $rubles;
            } catch (\Exception $e) {
                $this->logger->warning("Failed to get exchange rate from {sourceName}", [
                    'sourceName' => $source->getName(),
                    'error' => $e->getMessage(),
                ]);
            }
        }
        throw new RateSourceException("Couldn't load rates");
    }
}
