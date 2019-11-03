<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Infrastructure;

use JobOffersAnalyzer\Domain\Model;

interface AnalysisResultProcessor
{
    /**
     * @return Model\JobOffer[]
     */
    public function process(array $jobOffersModel);
}
