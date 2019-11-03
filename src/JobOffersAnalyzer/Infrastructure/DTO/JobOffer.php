<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Infrastructure\DTO;

class JobOffer
{
    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $title;

    /**
     * @var array
     */
    public $categories;
}
