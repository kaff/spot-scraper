<?php

namespace spec\App\Repository;

use App\Service\Scrapper;
use JobOffersAnalyzer\Infrastructure\DTO\JobOffer;
use JobOffersAnalyzer\Infrastructure\DTO\JobOfferDetails;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;

class JobOffersRepositorySpec extends ObjectBehavior
{
    private const JOB_OFFER_LIST_URL = '__JOB_OFFER_LIST_URL__';
    private const JOB_OFFER_DETAILS_URL = '__JOB_OFFER_DETAILS_URL__';
    private const JOB_OFFER_DESCRIPTION = '__JOB_OFFER_DESCRIPTION__';
    private const HEADERS = [
        'Content-Type' => 'application/x-www-form-urlencoded; charset=UTF-8',
    ];

    function let(ClientInterface $httpClient, Scrapper\JobOffer $scrapper)
    {
        $this->beConstructedWith($httpClient, $scrapper);
    }
    
    function it_should_return_job_offers_list(ClientInterface $httpClient)
    {
        $httpClient->request('POST', self::JOB_OFFER_LIST_URL, [
            'headers' => self::HEADERS,
            'body' => $this->prepareExpectedRequestBody($pageNr = 1)
        ])->willReturn($this->prepareResponseWithItems());

        $httpClient->request('POST', self::JOB_OFFER_LIST_URL, [
            'headers' => self::HEADERS,
            'body' => $this->prepareExpectedRequestBody($pageNr = 2)
        ])->willReturn($this->prepareEmptyResponse());

        $dto = $this->prepareExpectedJobOffer();

        $this->getOffersList(self::JOB_OFFER_LIST_URL)->shouldYieldLike(new \ArrayIterator([[$dto]]));
    }

    function it_should_return_job_offer_details(Scrapper\JobOffer $scrapper)
    {
        $scrapper->getDescription(self::JOB_OFFER_DETAILS_URL)->willReturn(self::JOB_OFFER_DESCRIPTION);

        $expectedDetails = new JobOfferDetails();
        $expectedDetails->description = self::JOB_OFFER_DESCRIPTION;

        $this->getJobOfferDetails(self::JOB_OFFER_DETAILS_URL)->shouldBeLike($expectedDetails);
    }

    private function prepareExpectedRequestBody(int $pageNr)
    {
        return http_build_query([
            'action' => 'get_jobs',
            'pageNr' => $pageNr,
            'perPage' => 30,
            'featuredJobs' => '',
            'category' => 0,
            'location' => 0,
            'search' => '',
            'locations' => [
                'sweden'
            ]
        ]);
    }

    private function prepareResponseWithItems()
    {
        $resposneBody = <<<EOT
            {
              "success": true,
              "data": {
                "items": [
                  {
                    "url": "__OFFER_URL__",
                    "title": "__TITLE__",
                    "categories": [
                      {
                        "url": "__CATEGORY_URL__",
                        "slug": "__CATEGORY_SLUG__",
                        "name": "__CATEGORY_NAME__"
                      }
                    ],
                    "locations": [
                      {
                        "url": "https:\/\/www.spotifyjobs.com\/search-jobs\/#location=stockholm",
                        "slug": "stockholm",
                        "name": "Stockholm"
                      },
                      {
                        "url": "https:\/\/www.spotifyjobs.com\/search-jobs\/#location=sweden",
                        "slug": "sweden",
                        "name": "Sweden"
                      }
                    ]
                  }
                ],
                "show_pager": true
              }
            }
EOT;

        return new Response(200, [], $resposneBody);
    }

    private function prepareEmptyResponse()
    {
        $resposneBody = <<<EOT
            {
              "success": true,
              "data": {
                "items": [
                ],
                "show_pager": true
              }
            }
EOT;

        return new Response(200, [], $resposneBody);
    }

    private function prepareExpectedJobOffer()
    {
        $category = new \stdClass();
        $category->url = '__CATEGORY_URL__';
        $category->slug = '__CATEGORY_SLUG__';
        $category->name = '__CATEGORY_NAME__';

        $dto = new JobOffer();
        $dto->url = '__OFFER_URL__';
        $dto->categories = [$category];
        $dto->title = '__TITLE__';

        return $dto;
    }
}
