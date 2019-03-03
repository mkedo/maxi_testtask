<?php

namespace MaxiTest\CurrencyBundle\Service;

use Doctrine\ORM\EntityManagerInterface;
use MaxiTest\CurrencyBundle\Entity\CurrencyRate;

class EuroExchangeRate
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * EuroRate constructor.
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function getRubles(): ?string
    {
        $repository = $this->em->getRepository(CurrencyRate::class);
        /**
         * @var $rate CurrencyRate
         */
        $rate = $repository->findOneBy(['code' => "EUR"]);
        if (isset($rate)) {
            return $rate->getRubles();
        } else {
            return null;
        }
    }
}
