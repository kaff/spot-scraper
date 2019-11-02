<?php
declare(strict_types=1);

namespace App\Command\JobOffersAnalyzer;

use GuzzleHttp;
use Goutte;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SpotifyCommand extends Command
{
    protected static $defaultName = 'JobOffersAnalyzer:spotify';

    /**
     * @var string
     */
    private $url;

    public function __construct(string $url)
    {
        $this->url = $url;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Analyze Spotify job offers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->text($this->url);

        $offersPackage = $this->getRawOffers();
        $analysedItems = [];
        foreach($offersPackage as $offers) {
            $analysedItems = array_reduce($offers, function($analysedItems, $offerItem) {

                $categories = array_map(function ($category) {
                    return $category->slug;
                }, $offerItem->categories);

//            $scrappedJobOffer = $this->getJobOffer($item->url);

                $analysedItems[] = array_merge([
                    'url' => $offerItem->url,
                    'categories' => $categories,
                    'forExperiencedProfessionals' => $this->offerForExperiencedProfessionals($offerItem->categories),
//                'requiredYearsOfExperience' => $this->getYearsOfExperience($scrappedJobOffer['description'], $categories)
                ], $scrappedJobOffer ?? []);

                return $analysedItems;

            }, $analysedItems);

        }


        file_put_contents('test.txt', print_r($analysedItems, true), FILE_APPEND);

        $io->success('OK');
        return 0;
    }

    private function getRawOffers()
    {
        $client = new GuzzleHttp\Client();
        $pageNumber = 1;
        do {
            $response = $client->request('POST', $this->url, [
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

            yield $items;
        } while (count($items) > 0);
    }

    private function getJobOffer($url)
    {
        $client = new Goutte\Client();
        $crawler = $client->request('GET', $url);
        $desc = trim($crawler->filter('div.entry-content')->text());

        return [
//            'description' => $desc
        ];
    }

    private function offerForExperiencedProfessionals(array $categories)
    {
        $filteredCategories = array_map(function ($category) {
            return mb_strtolower($category->name);
        }, $categories);
        return array_search('students', $filteredCategories) === false;
    }

    private function getYearsOfExperience(string $desc, $categories)
    {

        $test = "You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
Who you are
You have 3 years practical management experience with designers in an agile product development environment, and you are able to foster and grow the culture in cross-functional teams through advocacy.
You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
";


        $matches = [];
        preg_match('/[A-Z][a-z\s]*(\d).?(\d)?[\w\s,\\-]*experience[\w\s,\\-]*\./m', $desc, $matches);

        $requiredYears = 'n/a';
        if (!empty($matches[1])) {
            $requiredYears = $matches[1];
        }

        if (!empty($matches[2])) {
            $requiredYears .= '-'.$matches[2];
        }

        if (empty($requiredYears)) {
            if($this->offerForExperiencedProfessionals($categories)) {
                return '6';
            }
        }

        return $requiredYears;
    }
}
//[A-Z][a-z\s]*(\d).?(\d)?[\w\s,\\-]*experience[\w\s,\\-]*\.
//  (\d)?(\d)?years+

//You are willing to get hands-on, partnering closely with other functions and/or engineering teams.
//Who you are
//You have 3 years practical management experience with designers in an agile product development environment, and you are able to foster and grow the culture in cross-functional teams through advocacy.
//You’re comfortable working with partners to create holistic solutions involving both internal and external technology and products.
//You have 7+ years of related experience. You have 7-8 years of related experience. You have 5 years of related experience.
