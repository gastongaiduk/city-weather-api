<?php

namespace App\Services\Partners;

use App\Entity\Prediction;
use App\Exception\PartnerException;

interface PartnerInterface
{
    public static function getInternalID(): int;

    /**
     * @param Prediction $prediction
     * @return array
     * @throws PartnerException
     */
    public function getUpdatedTemperaturePredictions(Prediction $prediction): array;
}