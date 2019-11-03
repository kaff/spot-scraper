<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

class CategoryProvider
{
    /**
     * @return string[]
     */
    public function get(array $categories): array
    {
        return array_map(function ($category) {
            return $category->slug;
        }, $categories);
    }
}
