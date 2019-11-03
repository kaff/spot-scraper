<?php

declare(strict_types=1);

namespace App\Service\Scrapper;

interface JobOffer
{
    public function getDescription(string $url): string;

}
