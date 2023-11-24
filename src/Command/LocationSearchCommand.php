<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'location:search',
    description: 'Search for a location by country code and city name'
)]
class LocationSearchCommand extends Command
{
    private $locationRepository;

    public function __construct(LocationRepository $locationRepository)
    {
        $this->locationRepository = $locationRepository;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'Country (e.g., "US")')
            ->addArgument('city', InputArgument::REQUIRED, 'City')
            ->setDescription('Search for a location by country code and city name');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $country = $input->getArgument('country');
        $city = $input->getArgument('city');
    
        $location = $this->locationRepository->findByCountryAndCity($country, $city);
    
        if (!$location) {
            $io->error('Location not found.');
            return Command::FAILURE;
        }
    
        $io->writeln(sprintf('Location found: %s, %s, %s, %s',
            $location->getCity(),
            $location->getCountry(),
            $location->getLatitude(),
            $location->getLongitude()
        ));
    
        return Command::SUCCESS;
    }
}
