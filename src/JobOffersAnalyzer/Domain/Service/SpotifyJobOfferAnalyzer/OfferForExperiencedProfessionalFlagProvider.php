<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

use JobOffersAnalyzer\Infrastructure\DTO;

class OfferForExperiencedProfessionalFlagProvider
{
    private const CATEGORY_STUDENTS = 'students';

    public function getFlag(DTO\JobOffer $jobOffer): bool
    {
        $filteredCategories = array_map(function ($category) {
            return mb_strtolower($category->name);
        }, $jobOffer->categories);

        return array_search(self::CATEGORY_STUDENTS, $filteredCategories) === false;
    }
}
