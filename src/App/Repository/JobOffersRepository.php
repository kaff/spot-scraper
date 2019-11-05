<?php

declare(strict_types=1);

namespace App\Repository;

use App\Service\Scrapper;
use JobOffersAnalyzer\Infrastructure;
use JobOffersAnalyzer\Infrastructure\DTO\JobOfferDetails;
use GuzzleHttp\ClientInterface;

class JobOffersRepository implements Infrastructure\JobOffersRepository
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var Scrapper\JobOffer;
     */
    private $scrapper;

    public function __construct(ClientInterface $httpClient, Scrapper\JobOffer $scrapper)
    {
        $this->httpClient = $httpClient;
        $this->scrapper  = $scrapper;
    }

    /**
     * @return \Iterator<Infrastructure\DTO\JobOffer[]>
     */
    public function getOffersList(string $url): \Iterator
    {
        $pageNumber = 1;
        do {
            $response = $this->httpClient->request('POST', $url, [
                'headers' => [
                    'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
                ],
                'body' => http_build_query([
                    'action' => 'get_jobs',
                    'pageNr' => $pageNumber,
                    'perPage' => 30,
                    'featuredJobs' => '',
                    'category' => 0,
                    'location' => 0,
                    'search' => '',
                    'locations' => [
                        'sweden'
                    ]
                ])
            ]);

            $items = json_decode((string)$response->getBody())->data->items;
            $pageNumber++;

            if (count($items) > 0) {
                yield $this->mapToDTOSimpleJobOffer($items);
            }
        } while (count($items) > 0);
    }

    /**
     * @return Infrastructure\DTO\JobOffer[]
     */
    private function mapToDTOSimpleJobOffer(array $items): array {
        return array_map(function ($item) {
            $dto = new Infrastructure\DTO\JobOffer();
            $dto->url = $item->url;
            $dto->categories = $item->categories;
            $dto->title = $item->title;

            return $dto;
        }, $items);
    }

    public function getJobOfferDetails(string $url): JobOfferDetails
    {
        $dto = new JobOfferDetails();
        $dto->description = $this->scrapper->getDescription($url);

        return $dto;
    }
}
