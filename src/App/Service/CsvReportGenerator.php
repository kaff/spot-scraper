<?php

declare(strict_types=1);

namespace App\Service;

use JobOffersAnalyzer\Domain\Model;
use JobOffersAnalyzer\Infrastructure\AnalysisResultProcessor;

class CsvReportGenerator implements AnalysisResultProcessor
{
    /**
     * @var string
     */
    private $reportDir;

    public function __construct(string $reportDir)
    {
        $this->reportDir = $reportDir;
    }

    /**
     * @return Model\JobOffer[]
     */
    public function process(array $jobOffersModel)
    {
        $mapped = array_map(function (Model\JobOffer $item) {
            return [
                'url' => $item->getUrl(),
                'headline' => $item->getHeadline(),
                'description' => $item->getDescription(),
                'for_experienced_professionals' => $item->isForExperiencedProfessionals() ? 'true' : 'false',
                'required_years_of_experience' => $item->getRequiredYearsOfExperience() ?? 'n/a',
            ];
        }, $jobOffersModel);

        $fp = fopen($this->reportDir.'report.csv', 'w');

        foreach ($mapped  as $item) {
            fputcsv($fp, $item);
        }

        fclose($fp);
    }
}
