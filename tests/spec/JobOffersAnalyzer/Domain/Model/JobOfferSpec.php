<?php

namespace spec\JobOffersAnalyzer\Domain\Model;

use JobOffersAnalyzer\Domain\Model\JobOffer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JobOfferSpec extends ObjectBehavior
{
    private const URL = '__URL__'; 
    private const HEADLINE = '__HEADLINE__'; 
    private const CATEGORIES = ['__CATEGORY__'];
    private const FOR_EXPERIENCED_PROFESSIONALS  = false;
    private const DESCRIPTION = '__DESCRIPTION__';
    private const REQUIRED_YEARS_OF_EXPERIENCE = 1;

    function it_should_return_url()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );

        $this->getUrl()->shouldBe(self::URL);
    }

    function it_should_return_headline()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );
        
        $this->getHeadline()->shouldBe(self::HEADLINE);
    }

    function it_should_return_categories()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );
        
        $this->getCategories()->shouldBe(self::CATEGORIES);
    }

    function it_should_return_that_offer_is_for_experienced_professionals()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );
        
        $this->isForExperiencedProfessionals()->shouldBe(self::FOR_EXPERIENCED_PROFESSIONALS);
    }

    function it_should_return_description()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );
        
        $this->getDescription()->shouldBe(self::DESCRIPTION);
    }

    function it_should_return_required_years_of_experience()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );
        
        $this->getRequiredYearsOfExperience()->shouldBe(self::REQUIRED_YEARS_OF_EXPERIENCE);
    }

    function it_throws_error_when_url_is_empty()
    {
        $this->beConstructedWith(
            $url = '',
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_error_when_headline_is_empty()
    {
        $this->beConstructedWith(
            self::URL,
            $headline = '',
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            self::DESCRIPTION,
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }

    function it_throws_error_when_description_is_empty()
    {
        $this->beConstructedWith(
            self::URL,
            self::HEADLINE,
            self::CATEGORIES,
            self::FOR_EXPERIENCED_PROFESSIONALS,
            $desc = '',
            self::REQUIRED_YEARS_OF_EXPERIENCE
        );

        $this->shouldThrow(\InvalidArgumentException::class)->duringInstantiation();
    }
}
