<?php

namespace App\Services\Scales;

interface ScaleInterface
{
    public static function getInternalID(): int;

    public function getName(): string;

    public function convertArrayFromCelsius(array $temperatures): array;

    public function convertArrayFromFahrenheit(array $temperatures): array;
}