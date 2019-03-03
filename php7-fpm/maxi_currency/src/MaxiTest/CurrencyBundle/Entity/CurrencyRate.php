<?php

namespace MaxiTest\CurrencyBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="maxitest_currency_rates",uniqueConstraints={@ORM\UniqueConstraint(name="unq_code",columns={"code"})})
 *
 */
class CurrencyRate
{
    /** @ORM\Id @ORM\Column(type="integer") @ORM\GeneratedValue * */
    private $id;
    /**
     * @ORM\Column(type="string", length=3)
     * @var string
     */
    private $code;

    /**
     * @ORM\Column(type="string", length=255)
     * @var string
     */
    private $rubles;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     */
    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getRubles(): string
    {
        return $this->rubles;
    }

    /**
     * @param string $rubles
     */
    public function setRubles(string $rubles): void
    {
        $this->rubles = $rubles;
    }
}
