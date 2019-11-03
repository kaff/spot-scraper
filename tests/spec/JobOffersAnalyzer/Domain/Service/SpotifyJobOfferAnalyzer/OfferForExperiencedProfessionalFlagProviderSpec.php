<?php

namespace spec\JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\OfferForExperiencedProfessionalFlagProvider;
use JobOffersAnalyzer\Infrastructure\DTO\JobOffer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OfferForExperiencedProfessionalFlagProviderSpec extends ObjectBehavior
{
    private const CATEGORY_SOFTWARE_ENGINEERING_NAME = 'Software Engineering';
    private const CATEGORY_BUSINESS_INTERNSHIP_NAME = 'Business Internship';
    private const CATEGORY_STUDENTS_NAME = 'Students';

    function it_should_return_true_when_offer_is_not_in_students_category()
    {
        $category1 = new \stdClass();
        $category1->name = self::CATEGORY_BUSINESS_INTERNSHIP_NAME;

        $category2 = new \stdClass();
        $category2->name = self::CATEGORY_SOFTWARE_ENGINEERING_NAME;

        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->categories = [$category1, $category2];

        $this->getFlag($jobOfferDTO)->shouldBe(true);
    }

    function it_should_return_false_when_offer_is_in_students_category()
    {
        $category1 = new \stdClass();
        $category1->name = self::CATEGORY_BUSINESS_INTERNSHIP_NAME;

        $category2 = new \stdClass();
        $category2->name = self::CATEGORY_STUDENTS_NAME;

        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->categories = [$category1, $category2];

        $this->getFlag($jobOfferDTO)->shouldBe(false);
    }
}
