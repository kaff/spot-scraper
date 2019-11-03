<?php
declare(strict_types=1);

namespace App\Command\JobOffersAnalyzer;

use JobOffersAnalyzer\Application\UseCase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SpotifyCommand extends Command
{
    protected static $defaultName = 'JobOffersAnalyzer:spotify';

    /**
     * @var string
     */
    private $url;

    /**
     * @var UseCase\Spotify
     */
    private $useCaseSpotify;

    public function __construct(string $url, UseCase\ISpotify $useCaseSpotify)
    {
        $this->url = $url;
        $this->useCaseSpotify = $useCaseSpotify;

        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription('Analyze Spotify job offers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $command = new UseCase\SpotifyCommand();
        $command->url = $this->url;
        $this->useCaseSpotify->execute($command);

        $io->success('Report was generated. Check var/report.csv');
        return 0;
    }
}
