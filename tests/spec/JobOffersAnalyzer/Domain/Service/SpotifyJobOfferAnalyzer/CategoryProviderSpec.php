<?php

namespace spec\JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;

use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer\CategoryProvider;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CategoryProviderSpec extends ObjectBehavior
{
    private const CATEGORY_1_SLUG = '__CATEGORY_1__';
    private const CATEGORY_2_SLUG = '__CATEGORY_2__';
    
    function it_should_return_category_names()
    {
        $category1 = new \stdClass();
        $category1->slug = self::CATEGORY_1_SLUG;

        $category2 = new \stdClass();
        $category2->slug = self::CATEGORY_2_SLUG;
        
        $categories = [$category1, $category2];
        
        $this->get($categories)->shouldBeLike([self::CATEGORY_1_SLUG, self::CATEGORY_2_SLUG]);
    }
}
