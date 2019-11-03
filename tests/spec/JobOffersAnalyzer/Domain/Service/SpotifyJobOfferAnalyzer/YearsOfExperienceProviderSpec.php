<?php

namespace spec\JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\YearsOfExperienceProvider;
use JobOffersAnalyzer\Infrastructure\DTO\JobOffer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class YearsOfExperienceProviderSpec extends ObjectBehavior
{
    function it_should_return_amount_of_required_experience_in_years_when_description_includes_number_of_years()
    {
        $description = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You have 3 years practical management experience with designers in an agile product development environment, and you are able to foster and grow the culture in cross-functional teams through advocacy.
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";
        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->title = '__TITLE__';
        $this->get($description, $jobOfferDTO)->shouldBe(3);
    }

    function it_should_return_minimum_amount_of_required_experience_in_years_when_description_includes_range_of_years()
    {
        $description = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You have 4-5 years practical management experience with designers in an agile product development environment, and you are able to foster and grow the culture in cross-functional teams through advocacy.
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";
        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->title = '__TITLE__';
        $this->get($description, $jobOfferDTO)->shouldBe(4);
    }

    function it_should_return_amount_of_required_experience_in_years_when_description_includes_number_of_years_with_additional_symbol()
    {
        $description = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You have 7+ years practical management experience with designers in an agile product development environment, and you are able to foster and grow the culture in cross-functional teams through advocacy.
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";
        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->title = '__TITLE__';
        $this->get($description, $jobOfferDTO)->shouldBe(7);
    }

    function it_should_return_amount_of_required_experience_in_years_when_description_does_not_include_number_of_years_but_it_is_senior_position()
    {
        $description = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";
        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->title = 'Senior Product Designer';
        $this->get($description, $jobOfferDTO)->shouldBe(6);
    }

    function it_should_return_null_when_description_does_not_include_number_of_years_and_it_is_not_senior_position()
    {
        $description = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";
        $jobOfferDTO = new JobOffer();
        $jobOfferDTO->title = 'Product Designer';
        $this->get($description, $jobOfferDTO)->shouldBe(null);
    }
}
