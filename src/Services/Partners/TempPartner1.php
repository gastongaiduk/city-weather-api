<?php

namespace App\Services\Partners;

use App\Entity\Prediction;

class TempPartner1 implements PartnerInterface
{
    public static function getInternalID(): int
    {
        return 1;
    }

    public function getUpdatedTemperaturePredictions(Prediction $prediction): array
    {
        // We suppose to be throwing a request to our partner using $predictions parameters (city & day)
        $data = file_get_contents( __DIR__ . '/../../../data-sources/temps.csv');
        $lines = explode(PHP_EOL, $data);
        $array = [];
        foreach ($lines as $lineKey => $line) {
            $values = str_getcsv($line);
            if($lineKey === 0 || empty($values) || count($values) < 5){
                continue;
            }
            if($lineKey === 1){
                $array['-scale'] = $values[0];
                $array['city'] = $values[1];
                $array['date'] = $values[2];
            }
            $array['prediction'][] = [
                'time' => $values[3],
                'value' => (float)$values[4]
            ];
        }
        return $array;
    }
}