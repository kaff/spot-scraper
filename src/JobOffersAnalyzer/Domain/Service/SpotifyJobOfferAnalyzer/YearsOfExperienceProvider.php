<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

use JobOffersAnalyzer\Infrastructure\DTO;

class YearsOfExperienceProvider
{
    private const SENTENCE_WITH_YEARS_OF_EXPERIENCE_REGEXP = '/[A-Z][a-z\s]*(\d).?(\d)?[\w\s,\\-]*experience[\w\s,\\-]*\./m';
    private const MATCHED_YEARS_RANGE_FROM = 1;
    private const MIN_YEARS_OF_EXPERIENCE_FOR_SENIOR_POSITION = 6;
    private const SENIOR_POSITION_LABEL = 'senior';

    public function get(string $description, DTO\JobOffer $jobOffer): ?int
    {
        $matches = [];
        preg_match(self::SENTENCE_WITH_YEARS_OF_EXPERIENCE_REGEXP, $description, $matches);

        $requiredYears = null;
        if (!empty($matches[self::MATCHED_YEARS_RANGE_FROM])) {
            return (int)$matches[self::MATCHED_YEARS_RANGE_FROM];
        }

        if($this->isSeniorPosition($jobOffer)) {
            return self::MIN_YEARS_OF_EXPERIENCE_FOR_SENIOR_POSITION;
        }

        return null;
    }

    private function isSeniorPosition(DTO\JobOffer $jobOffer): bool
    {
        return strpos(mb_strtolower($jobOffer->title), self::SENIOR_POSITION_LABEL) !== false;
    }
}
