<?php

namespace spec\JobOffersAnalyzer\Application\UseCase;

use JobOffersAnalyzer\Application\UseCase\SpotifyCommand;
use JobOffersAnalyzer\Domain\Model\JobOffer;
use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;
use JobOffersAnalyzer\Infrastructure\AnalysisResultProcessor;
use PhpSpec\ObjectBehavior;

class SpotifySpec extends ObjectBehavior
{
    private const URL = '__URL__';

    function let(SpotifyJobOfferAnalyzer $analyzer, AnalysisResultProcessor $analysisResultProcessor)
    {
        $this->beConstructedWith($analyzer, $analysisResultProcessor);
    }

    function it_should_analyze_items_and_process_results(
        SpotifyJobOfferAnalyzer $analyzer,
        AnalysisResultProcessor $analysisResultProcessor
    ) {
        $command = new SpotifyCommand();
        $command->url = self::URL;

        $jobOffers = [$this->prepareJobOffer()];

        $analyzer->analyze(self::URL)->willReturn($jobOffers);
        $analysisResultProcessor->process($jobOffers)->willReturn('__RESULT__');
        
        $this->execute($command)->shouldBe('__RESULT__');
    }

    private function prepareJobOffer()
    {
        return new JobOffer(
            '__JO_URL__',
            '__JO_HEADLINE__',
            [],
            false,
            '__JO_DESC__',
            null
        );
    }
}
