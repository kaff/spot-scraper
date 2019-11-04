<?php

declare(strict_types=1);

namespace Tests\integration;

use App\Service\CsvReportGenerator;
use JobOffersAnalyzer\Domain\Model\JobOffer;
use PHPUnit\Framework\TestCase;

class CsvReportGeneratorTest extends TestCase
{
    private const REPORT_PATH = 'var/test/';

    /**
     * @var CsvReportGenerator
     */
    private $generator;

    public function setUp()
    {
        $this->generator = new CsvReportGenerator(self::REPORT_PATH);

        $this->prepareReportDir();
        $this->removeOldReport();
    }

    public function test_it_should_generate_csv_report()
    {
        $jobOffers = $this->prepareData();

        $this->generator->process($jobOffers);

        $this->assertReportContentEquals($this->getExpectedReport());
    }

    private function prepareReportDir()
    {
        if (!file_exists(self::REPORT_PATH)) {
            mkdir(self::REPORT_PATH, 0777);
        }
    }

    private function removeOldReport()
    {
        @unlink(self::REPORT_PATH.'report.csv');
    }

    private function prepareData()
    {
        $item1 = new JobOffer(
            '__URL_1__',
            '__HEADLINE_1__',
            ['students'],
            true,
            '__DESCRIPTION_1__',
            null
        );

        $item2 = new JobOffer(
            '__URL_2__',
            '__HEADLINE_2__',
            ['other-category'],
            false,
            '__DESCRIPTION_2__',
            2
        );

        return [
            $item1,
            $item2
        ];
    }

    private function getExpectedReport(): string
    {
        return <<<EOT
__URL_1__,__HEADLINE_1__,__DESCRIPTION_1__,true,n/a
__URL_2__,__HEADLINE_2__,__DESCRIPTION_2__,false,2

EOT;
    }


    private function assertReportContentEquals($expectedContent)
    {
        $content = @file_get_contents(self::REPORT_PATH.'report.csv');
        $this->assertEquals($expectedContent, $content);
    }
}
