<?php

namespace App\Services\Partners;

use App\Entity\Prediction;

class TempPartner2 implements PartnerInterface
{
    public static function getInternalID(): int
    {
        return 2;
    }

    public function getUpdatedTemperaturePredictions(Prediction $prediction): array
    {
        // We suppose to be throwing a request to our partner using $predictions parameters (city & day)
        $data = simplexml_load_string(file_get_contents(__DIR__ . '/../../../data-sources/temps.xml'));
        $array = [
            '-scale' => (string)$data['scale'],
            'city' => (string)$data->city,
            'date' => (string)$data->date,
            'prediction' => []
        ];
        foreach ($data->prediction as $item){
            $array['prediction'][] = [
                'time' => (string)$item->time,
                'value' => (float)$item->value
            ];
        }
        return $array;
    }
}