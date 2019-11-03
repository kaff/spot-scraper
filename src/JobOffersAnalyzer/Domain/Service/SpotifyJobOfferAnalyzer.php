<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Domain\Service;

use JobOffersAnalyzer\Domain\Model;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\CategoryProvider;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\OfferForExperiencedProfessionalFlagProvider;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\YearsOfExperienceProvider;
use JobOffersAnalyzer\Infrastructure\DTO;
use JobOffersAnalyzer\Infrastructure\JobOffersRepository;

class SpotifyJobOfferAnalyzer
{
    private $analysedItems = [];

    /**
     * @var JobOffersRepository
     */
    private $jobOffersRepository;

    /**
     * @var CategoryProvider
     */
    private $categoryProvider;

    /**
     * @var OfferForExperiencedProfessionalFlagProvider
     */
    private $experiencedProfessionalFlagProvider;

    /**
     * @var YearsOfExperienceProvider
     */
    private $yearsOfExperienceProvider;

    public function __construct(
        JobOffersRepository $jobOffersRepository,
        CategoryProvider $categoryProvider,
        OfferForExperiencedProfessionalFlagProvider $experiencedProfessionalFlagProvider,
        YearsOfExperienceProvider $yearsOfExperienceProvider
    ) {
        $this->jobOffersRepository = $jobOffersRepository;
        $this->categoryProvider = $categoryProvider;
        $this->experiencedProfessionalFlagProvider = $experiencedProfessionalFlagProvider;
        $this->yearsOfExperienceProvider = $yearsOfExperienceProvider;
    }

    /**
     * @return Model\JobOffer[]
     */
    public function analyze(string $url): array
    {
        $offersPackage = $this->jobOffersRepository->getOffersList($url);

        foreach($offersPackage as $offers) {
            $this->analyzeOffers($offers);
        }

        return $this->analysedItems;
    }

    /**
     * @param DTO\JobOffer[] $offers
     */
    private function analyzeOffers(array $offers): void
    {
        foreach ($offers as $offerItem) {
            /** @var DTO\JobOffer $offerItem */

            $scrappedJobOffer = $this->jobOffersRepository->getJobOfferDetails($offerItem->url);
            $categories = $this->categoryProvider->get($offerItem->categories);

            $jobOfferModel = new Model\JobOffer(
                $offerItem->url,
                $offerItem->title,
                $categories,
                $this->experiencedProfessionalFlagProvider->getFlag($offerItem),
                $scrappedJobOffer->description,
                $this->yearsOfExperienceProvider->get($scrappedJobOffer->description, $offerItem)
            );

            $this->analysedItems[] = $jobOfferModel;
        }
    }
}
