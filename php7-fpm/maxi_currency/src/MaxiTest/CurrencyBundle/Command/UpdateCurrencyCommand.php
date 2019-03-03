<?php

namespace MaxiTest\CurrencyBundle\Command;

use MaxiTest\CurrencyBundle\Service\EuroExchangeRateUpdater;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Command\LockableTrait;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateCurrencyCommand extends Command
{
    use LockableTrait;

    protected static $defaultName = 'maxitest:update-currency';

    /**
     * @var EuroExchangeRateUpdater
     */
    private $euroRate;

    public function __construct(EuroExchangeRateUpdater $euroRate)
    {
        $this->euroRate = $euroRate;
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription("Updates EUR-RUB exchange rate.");
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$this->lock()) {
            $output->writeln('The command is already running in another process.');
            return 0;
        }

        $output->writeln("Updating currency...");
        $this->euroRate->update();
        $output->writeln("Updated");

        $this->release();
    }
}
