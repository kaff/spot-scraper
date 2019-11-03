<?php

namespace spec\JobOffersAnalyzer\Domain\Service;

use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\CategoryProvider;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\OfferForExperiencedProfessionalFlagProvider;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\YearsOfExperienceProvider;
use JobOffersAnalyzer\Infrastructure\DTO\JobOffer;
use JobOffersAnalyzer\Infrastructure\DTO\JobOfferDetails;
use JobOffersAnalyzer\Infrastructure\JobOffersRepository;
use JobOffersAnalyzer\Domain\Model;
use PhpSpec\ObjectBehavior;

class SpotifyJobOfferAnalyzerSpec extends ObjectBehavior
{
    private const URL = '__URL__';
    private const JOB_OFFER_URL = '__JOB_OFFER_URL__';
    private const JOB_OFFER_TITLE = '__JOB_OFFER_TITLE__';
    private const JOB_OFFER_DETAILS_DESCRIPTION = '__DESCRIPTION__';
    private const CATEGORY_SLUG = '__CATEGORY_SLUG__';
    private const EXPERIENCED_PROFESSIONAL = false;
    private const YEARS_OF_EXPERIENCE = 6;

    function let(
        JobOffersRepository $jobOffersRepository,
        CategoryProvider $categoryProvider,
        OfferForExperiencedProfessionalFlagProvider $experiencedProfessionalFlagProvider,
        YearsOfExperienceProvider $yearsOfExperienceProvider
    ) {
        $this->beConstructedWith(
            $jobOffersRepository,
            $categoryProvider,
            $experiencedProfessionalFlagProvider,
            $yearsOfExperienceProvider
        );
    }

    function it_should_analyze_job_offer(
        JobOffersRepository $jobOffersRepository,
        CategoryProvider $categoryProvider,
        OfferForExperiencedProfessionalFlagProvider $experiencedProfessionalFlagProvider,
        YearsOfExperienceProvider $yearsOfExperienceProvider        
    ) {
        $jobOfferDTO = $this->prepareJobOfferDTO();
        $jobOfferDetailsDTO = $this->prepareJobOfferDetailsDTO();
        
        $jobOffersRepository->getOffersList(self::URL)->willReturn(new \ArrayIterator([[$jobOfferDTO]]));
        $jobOffersRepository->getJobOfferDetails(self::JOB_OFFER_URL)->willReturn($jobOfferDetailsDTO);
        $categoryProvider->get($jobOfferDTO->categories)->willReturn([self::CATEGORY_SLUG]);
        $experiencedProfessionalFlagProvider->getFlag($jobOfferDTO)->willReturn(self::EXPERIENCED_PROFESSIONAL);
        $yearsOfExperienceProvider->get(self::JOB_OFFER_DETAILS_DESCRIPTION, $jobOfferDTO)->willReturn(self::YEARS_OF_EXPERIENCE);
        
        $expectedJobOffer = new Model\JobOffer(
            self::JOB_OFFER_URL, 
            self::JOB_OFFER_TITLE,
            [self::CATEGORY_SLUG], 
            self::EXPERIENCED_PROFESSIONAL, 
            self::JOB_OFFER_DETAILS_DESCRIPTION, 
            self::YEARS_OF_EXPERIENCE
        );
        
        $this->analyze(self::URL)->shouldBeLike([$expectedJobOffer]);
    }

    private function prepareJobOfferDTO()
    {
        $category = new \stdClass();
        $category->url = '__CATEGORY_URL__';
        $category->slug = self::CATEGORY_SLUG;
        $category->name = '__CATEGORY_NAME__';

        $dto = new JobOffer();
        $dto->url = self::JOB_OFFER_URL;
        $dto->categories = [$category];
        $dto->title = self::JOB_OFFER_TITLE;

        return $dto;
    }
    
    private function prepareJobOfferDetailsDTO()
    {
        $dto = new JobOfferDetails();
        $dto->description = self::JOB_OFFER_DETAILS_DESCRIPTION;

        return $dto;
    }
}
