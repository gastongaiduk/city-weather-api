<?php

namespace App\Services\Partners;

use App\Entity\Prediction;

class TempPartner3 implements PartnerInterface
{
    public static function getInternalID(): int
    {
        return 3;
    }

    public function getUpdatedTemperaturePredictions(Prediction $prediction): array
    {
        // We suppose to be throwing a request to our partner using $predictions parameters (city & day)
        $data = json_decode(file_get_contents(__DIR__ . '/../../../data-sources/temps.json'), true);
        return $data['predictions'];
    }
}