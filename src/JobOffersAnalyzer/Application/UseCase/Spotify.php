<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Application\UseCase;

use JobOffersAnalyzer\Domain\Service\SpotifyJobOfferAnalyzer;
use JobOffersAnalyzer\Infrastructure\AnalysisResultProcessor;

class Spotify implements ISpotify
{
    /**
     * @var SpotifyJobOfferAnalyzer
     */
    private $analyzer;

    /**
     * @var AnalysisResultProcessor
     */
    private $resultProcessor;

    public function __construct(SpotifyJobOfferAnalyzer $analyzer, AnalysisResultProcessor $analysisResultProcessor)
    {
        $this->analyzer = $analyzer;
        $this->resultProcessor = $analysisResultProcessor;
    }

    public function execute(SpotifyCommand $command)
    {
        $analysedItems = $this->analyzer->analyze($command->url);

        return $this->resultProcessor->process($analysedItems);
    }
}
