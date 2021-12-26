<?php

namespace App\Services\Scales;


abstract class ScaleFactory
{
    public static function make(int $identifier): ?ScaleInterface
    {
        switch ($identifier){
            case CelsiusScale::getInternalID():
                return new CelsiusScale();
            case FahrenheitScale::getInternalID():
                return new FahrenheitScale();
            default:
                return null;
        }
    }
}