<?php

namespace App\Tests\Entity;

use PHPUnit\Framework\TestCase;
use App\Entity\Measurement;

class MeasurementTest extends TestCase
{
    /**
     * @dataProvider dataGetFahrenheit
     */
    public function testGetFahrenheit(float $celsius, float $expectedFahrenheit): void
    {
        $measurement = new Measurement();
        $measurement->setCelsius($celsius);
        $this->assertEquals(
            $expectedFahrenheit,
            $measurement->getFahrenheit(),
            sprintf("%.1f°C should equal %.1f°F", $celsius, $expectedFahrenheit)
        );
        }

    public function dataGetFahrenheit(): array
    {
        return [
            [0, 32],
            [-100, -148],
            [100, 212],
            [25, 77],
            [-40, -40],
            [0.5, 32.9],
            [37, 98.6],
            [15.5, 59.9],
            [-10, 14],
            [50, 122],
        ];
    }
}
