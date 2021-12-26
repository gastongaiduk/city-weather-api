<?php

namespace App\Services\Scales;

class FahrenheitScale implements ScaleInterface
{

    public static function getInternalID(): int
    {
        return 2;
    }

    public function getName(): string
    {
        return 'Fahrenheit';
    }

    public function convertArrayFromCelsius(array $temperatures): array
    {
        foreach ($temperatures as &$item){
            if(array_key_exists('value', $item)){
                $item['value'] = round($item['value']*(1.8)+32, 1);
            }
        }
        return $temperatures;
    }

    public function convertArrayFromFahrenheit(array $temperatures): array
    {
        return $temperatures;
    }
}