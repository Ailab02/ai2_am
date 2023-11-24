<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Repository\LocationRepository;
use App\Service\WeatherUtil;

#[AsCommand(
    name: 'weather:location',
    description: 'Get weather forecast for a specific location'
)]
class WeatherLocationCommand extends Command
{
    private $locationRepository;
    private $weatherUtil;

    public function __construct(LocationRepository $locationRepository, WeatherUtil $weatherUtil)
    {
        $this->locationRepository = $locationRepository;
        $this->weatherUtil = $weatherUtil;

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('id', InputArgument::REQUIRED, 'Location ID')
            ->setDescription('Get weather forecast for a specific location');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $locationId = $input->getArgument('id');
        $location = $this->locationRepository->find($locationId);

        if (!$location) {
            $io->error('Location not found.');
            return Command::FAILURE;
        }

        $measurements = $this->weatherUtil->getWeatherForLocation($location);
        $io->writeln(sprintf('Weather forecast for %s:', $location->getCity()));

        foreach ($measurements as $measurement) {
            $io->writeln(sprintf("\t%s: %s°C",
                $measurement->getDate()->format('Y-m-d'),
                $measurement->getCelsius()
            ));
        }

        return Command::SUCCESS;
    }
}
