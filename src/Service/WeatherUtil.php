<?php
declare(strict_types=1);

namespace App\Service;

use App\Entity\Location;
use App\Entity\Measurement;
use App\Repository\MeasurementRepository;
use App\Repository\LocationRepository;

class WeatherUtil
{
    public function __construct(private readonly MeasurementRepository $measurementRepository, private readonly LocationRepository $locationRepository)
    {
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForLocation(Location $location): array
    {
        $measurements = $this->measurementRepository->findByLocation($location);
        return $measurements;
    }

    /**
     * @return Measurement[]
     */
    public function getWeatherForCountryAndCity(string $countryCode, string $city): array
    {
        $location = $this->locationRepository->findOneBy([
            'country' => $countryCode,
            'city' => $city,
        ]);

        if (!$location) {
            throw new \InvalidArgumentException('Location not found');
        }

        return $this->getWeatherForLocation($location);
    }
}
