<?php
declare(strict_types=1);

namespace JobOffersAnalyzer\Application\UseCase;

use JobOffersAnalyzer\Domain\Model\SpotifyReport;

interface ISpotify
{
    public function execute(SpotifyCommand $command);
}
