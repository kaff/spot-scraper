<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class MockServerContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Application
     */
    private $application;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @Given there are job offers on spotify website
     */
    public function thereAreJobOffersOnSpotifyWebsite()
    {
        $serverScript = basename(__DIR__) . DIRECTORY_SEPARATOR
        . 'simple-mock-server' . DIRECTORY_SEPARATOR
        . 'index.php';
        
//        exec('php -S localhost:8000 '.$serverScript.' > serv_error.txt &');
    }
}
