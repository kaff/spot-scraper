<?php

declare(strict_types=1);

namespace JobOffersAnalyzer\Domain\Model;

class JobOffer
{
    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $headline;

    /**
     * @var string[]
     */
    private $categories;

    /**
     * @var bool
     */
    private $forExperiencedProfessionals;

    /**
     * @var int|null
     */
    private $requiredYearsOfExperience;

    /**
     * @var string
     */
    private $description;

    public function __construct(
        string $url,
        string $headline,
        array $categories,
        bool $forExperiencedProfessionals,
        string $description,
        ?int $requiredYearsOfExperience
    ) {
        $this->guardUrl($url);
        $this->guardHeadline($headline);
        $this->guardDescription($description);

        $this->url = $url;
        $this->headline = $headline;
        $this->categories = $categories;
        $this->forExperiencedProfessionals = $forExperiencedProfessionals;
        $this->description = $description;
        $this->requiredYearsOfExperience = $requiredYearsOfExperience;
    }

    private function guardUrl(string $url)
    {
        if (empty($url)) {
            throw new \InvalidArgumentException('Url cannot be empty');
        }
    }

    private function guardHeadline(string $headline)
    {
        if (empty($headline)) {
            throw new \InvalidArgumentException('Headline cannot be empty');
        }
    }

    private function guardDescription(string $description)
    {
        if (empty($description)) {
            throw new \InvalidArgumentException('Description cannot be empty');
        }
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getHeadline(): string
    {
        return $this->headline;
    }

    /**
     * @return string[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    public function isForExperiencedProfessionals(): bool
    {
        return $this->forExperiencedProfessionals;
    }

    public function getRequiredYearsOfExperience(): ?int
    {
        return $this->requiredYearsOfExperience;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
