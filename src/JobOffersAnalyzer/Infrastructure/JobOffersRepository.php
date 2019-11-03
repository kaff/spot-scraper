<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Infrastructure;

use JobOffersAnalyzer\Infrastructure\DTO\JobOfferDetails;
use JobOffersAnalyzer\Infrastructure\DTO\JobOffer;

interface JobOffersRepository
{
    /**
     * @param string $url
     * @return \Iterator<JobOffer>
     */
    public function getOffersList(string $url): \Iterator;

    public function getJobOfferDetails(string $url): JobOfferDetails;
}
