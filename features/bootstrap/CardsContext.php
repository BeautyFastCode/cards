<?php

use Behat\Behat\Context\Context;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;

class CardsContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * Class constructor
     *
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given /^there are fixtures refreshed$/
     */
    public function thereAreFixturesRefreshed()
    {
        $application = new Application($this->kernel);
        $application->setAutoExit(false);

        /*
         * todo: don't refresh all - but only changed entities
         */
        $input = new ArrayInput(array(
            'command' => 'hautelook:fixtures:load',

            '--no-interaction',
        ));

        $application->run($input);
    }
}
