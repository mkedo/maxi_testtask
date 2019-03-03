<?php

namespace MaxiTest\CurrencyBundle;

interface EuroRateSource
{
    /**
     * @return string source name.
     */
    public function getName(): string;

    /**
     * @return string how many rubles for one euro
     * @throws RateSourceException
     */
    public function getRubles(): string;
}
