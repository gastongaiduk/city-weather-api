<?php

namespace App\Services\Scales;

class CelsiusScale implements ScaleInterface
{
    public static function getInternalID(): int
    {
        return 1;
    }

    public function getName(): string
    {
        return 'Celsius';
    }

    public function convertArrayFromCelsius(array $temperatures): array
    {
        return $temperatures;
    }

    public function convertArrayFromFahrenheit(array $temperatures): array
    {
        foreach ($temperatures as &$item){
            if(array_key_exists('value', $item)){
                $item['value'] = round(($item['value']-32) * 5/9, 1);
            }
        }
        return $temperatures;
    }
}