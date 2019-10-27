<?php

namespace App\Command\JobOffersAnalyzer;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SpotifyCommand extends Command
{
    protected static $defaultName = 'JobOffersAnalyzer:spotify';

    protected function configure()
    {
        $this->setDescription('Analyze Sporify job offers');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');
        return 0;
    }
}
