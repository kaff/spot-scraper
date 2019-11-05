<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Output\BufferedOutput;
use PHPUnit\Framework\Assert;

class CommandContext implements Context
{
    private const REPORT_PATH = 'var/test/';
    private const COLUMN_HEADERS = 0;

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

    /**
     * @var string
     */
    private $basePath;

    public function __construct(KernelInterface $kernel, string $basePath)
    {
        $this->kernel = $kernel;
        $this->application = new Application($kernel);
        $this->output = new BufferedOutput();
        $this->basePath = $basePath;
    }

    /**
     * @BeforeScenario
     */
    public static function createReportDir()
    {
        if (!file_exists(self::REPORT_PATH)) {
            mkdir(self::REPORT_PATH, 0777);
        }
    }

    /**
     * @Given there are job offers on spotify website
     */
    public function thereAreJobOffersOnSpotifyWebsite()
    {
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
        $tableRows = $table->getRows();
        unset($tableRows[self::COLUMN_HEADERS]);
        $expectedRows = array_values($tableRows);

        $i = 0;
        $handle = fopen($this->basePath . DIRECTORY_SEPARATOR . $reportPath, "r");
        while (($generatedReportRow = fgetcsv($handle)) !== FALSE) {
            Assert::assertEquals(
                $expectedRows[$i],
                $generatedReportRow
            );

            $i++;
        }
    }
}
