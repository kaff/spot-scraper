<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;

class CommandContext implements Context
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * @var Application
     */
    private $application;

    /**
     * @var BufferedOutput
     */
    private $output;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
    }

    /**
     * @When I run analyzer by command :command
     */
    public function iRunAnalyzerByCommand($command)
    {
        $input = new ArgvInput(['command-test', $command, '--env=test']);
        $this->application->doRun($input, $this->output);
    }

    /**
     * @Then I have CVS report in :reportPath with data:
     */
    public function iHaveCvsReportInWithData($reportPath, TableNode $table)
    {
//        throw new PendingException();
    }
}
