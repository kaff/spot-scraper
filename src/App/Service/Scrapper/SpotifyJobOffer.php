<?php

declare(strict_types=1);

namespace App\Service\Scrapper;

use Symfony\Component\BrowserKit\Client as Scrapper;

class SpotifyJobOffer implements JobOffer
{
    private const JOB_OFFER_DESCRIPTION_SELECTOR = 'div.entry-content';

    /**
     * @var Scrapper
     */
    private $scrapper;

    public function __construct(Scrapper $scrapper)
    {
        $this->scrapper = $scrapper;
    }

    public function getDescription(string $url): string
    {
        $crawler = $this->scrapper->request('GET', $url);

        return trim($crawler->filter(self::JOB_OFFER_DESCRIPTION_SELECTOR)->text());
    }
}
