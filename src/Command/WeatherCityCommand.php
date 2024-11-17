<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use App\Service\WeatherUtil;
use App\Repository\LocationRepository;

#[AsCommand(
    name: 'weather:city',
    description: 'City measurments',
)]
class WeatherCityCommand extends Command
{
    public function __construct(private readonly WeatherUtil $weatherUtil, private readonly LocationRepository $locationRepository, string $city = null)
    {
        parent::__construct($city);
    }

    protected function configure(): void
    {
        $this
            ->addArgument('country', InputArgument::REQUIRED, 'The code of the country.')
            ->addArgument('city', InputArgument::REQUIRED, 'The city.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $code_country = $input->getArgument('country');
        $city = $input->getArgument('city');
        $loc = $this->locationRepository->findOneBy(['country' => $code_country, 'city' => $city]);
        $meas = $this->weatherUtil->getWeatherForLocation($loc);
        $io->writeln('Location: ' . $loc->getCity() . ', ' . $loc->getCountry());
        $io->writeln('Measurements: ' . count($meas));
        for ($i = 0; $i < count($meas); $i++) {
            $io->writeln(sprintf('Date: %s, Temperature: %s, Wind: %s, Humidity: %s',
                    $meas[$i]->getDate()->format('Y-m-d'),
                    $meas[$i]->getCelsius(),
                    $meas[$i]->getWind(),
                    $meas[$i]->getHumidity()
                )
            );
        }

        return Command::SUCCESS;
    }
}
