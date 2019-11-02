<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Application\UseCase;

use JobOffersAnalyzer\Domain\SpotifyReport;

class Spotify implements ISpotify
{
    public function __construct()
    {

    }

    public function execute(SpotifyCommand $command): SpotifyReport
    {

    }
}
