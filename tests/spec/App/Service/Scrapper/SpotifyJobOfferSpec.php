<?php

namespace spec\App\Service\Scrapper;

use App\Service\Scrapper\SpotifyJobOffer;
use Symfony\Component\BrowserKit\Client as Scrapper;
use Symfony\Component\DomCrawler\Crawler;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpotifyJobOfferSpec extends ObjectBehavior
{
    private const URL = '__URL__';

    function let(Scrapper $scrapper)
    {
        $this->beConstructedWith($scrapper);
    }

    function it_should_return_job_offer_description(Scrapper $scrapper, Crawler $crawler)
    {
        $crawler->text()->willReturn('    __DESCRIPTION__    ');
        $crawler->filter('div.entry-content')->willReturn($crawler);

        $scrapper->request('GET', self::URL)->willReturn($crawler);

        $this->getDescription(self::URL)->shouldBeEqualTo('__DESCRIPTION__');
    }
}
