<?php

namespace App\Services;


use App\Services\Scales\CelsiusScale;
use App\Services\Scales\FahrenheitScale;
use App\Services\Scales\ScaleInterface;

class ScaleConverterService
{

    /**
     * @param array $temperaturesToConvert
     * @param ScaleInterface $scale
     * @param int $originScale
     * @return array
     */
    public function __invoke(array $temperaturesToConvert, ScaleInterface $scale, int $originScale): array
    {
        switch ($originScale){
            case CelsiusScale::getInternalID():
                $convertedTemperatures = $scale->convertArrayFromCelsius($temperaturesToConvert);
                break;
            case FahrenheitScale::getInternalID():
                $convertedTemperatures = $scale->convertArrayFromFahrenheit($temperaturesToConvert);
                break;
            default:
                $convertedTemperatures = $temperaturesToConvert;
        }

        return $convertedTemperatures;
    }

}