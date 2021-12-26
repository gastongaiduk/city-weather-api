<?php

namespace App\Services\Partners;

use App\Entity\Prediction;
use App\Exception\PartnerException;

class TempPartner4 implements PartnerInterface
{
    public static function getInternalID(): int
    {
        return 4;
    }

    public function getUpdatedTemperaturePredictions(Prediction $prediction): array
    {
        // We suppose to be throwing a request to our partner using $predictions parameters (city & day)
        throw new PartnerException('Simulating partner service exception', 404);
    }
}