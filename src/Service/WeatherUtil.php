<?php  
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\LocationRepository;
use App\Repository\MeasurementRepository;

class WeatherUtil
{
    private $locationRepository;
    private $measurementRepository;

    public function __construct(
        LocationRepository $locationRepository,
        MeasurementRepository $measurementRepository
    ) {
        $this->locationRepository = $locationRepository;
        $this->measurementRepository = $measurementRepository;
    }

    public function getWeatherForLocation(Location $location): array
    {
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }

    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy(['countryCode' => $countryCode, 'city' => $city]);
        $measurements = $this->getWeatherForLocation($location);
        return $measurements;
    }
}
