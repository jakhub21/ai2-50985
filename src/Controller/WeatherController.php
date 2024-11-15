<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Location;
use App\Repository\MeasurementRepository;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use App\Service\WeatherUtil;

class WeatherController extends AbstractController
{
    #[Route('/weather/{country}/{city}', name: 'app_weather', requirements:  ['id' => '\d+'])]
    public function city(
        #[MapEntity(mapping: ['country' => 'country', 'city' => 'city'])]
        Location $location,
        WeatherUtil $util,
    ): Response
    {
        $measurements = $util->getWeatherForLocation($location);

        return $this->render('weather/city.html.twig', [
            'location' => $location,
            'measurements' => $measurements,
        ]);
    }

}
