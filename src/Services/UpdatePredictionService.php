<?php

namespace App\Services;


use App\Entity\Prediction;
use App\Exception\PartnerException;
use App\Services\Partners\PartnerFactory;
use App\Services\Partners\PartnerInterface;
use App\Services\Scales\CelsiusScale;
use App\Services\Scales\FahrenheitScale;
use App\Services\Scales\ScaleFactory;
use Doctrine\ORM\EntityManagerInterface;

class UpdatePredictionService
{
    private const PARTNERS_TO_EXECUTE = [1, 2, 3, 4];

    /** @var ScaleConverterService */
    private $scaleConverterService;

    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * @param ScaleConverterService $scaleConverterService
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(ScaleConverterService $scaleConverterService, EntityManagerInterface $entityManager)
    {
        $this->scaleConverterService = $scaleConverterService;
        $this->entityManager = $entityManager;
    }

    /**
     * @param Prediction $prediction
     */
    public function __invoke(Prediction $prediction): void
    {
        $temperatures = [];
        foreach (self::PARTNERS_TO_EXECUTE as $partnerId){
            $service = PartnerFactory::make($partnerId);
            if($service instanceof PartnerInterface === false){
                continue;
            }
            try{
                $temperatures[] = $service->getUpdatedTemperaturePredictions($prediction);
            } catch (PartnerException $e){
                // Log partner service exception
            }
        }

        $prediction->setTemperatures($this->getAveragePredictions($temperatures));
        $this->entityManager->persist($prediction);
        $this->entityManager->flush();
    }

    /**
     * @param array $temperatures
     * @return void
     */
    private function getAveragePredictions(array $temperatures): array
    {
        $averageTemperatures = [];
        $completeTemperatures = [];
        foreach ($temperatures as $temperature){
            if(empty($temperature)){
                continue;
            }
            if(strtolower($temperature['-scale']) === 'fahrenheit'){
                $temperature['prediction'] =
                    $this->scaleConverterService->__invoke(
                        $temperature['prediction'],
                        ScaleFactory::make(CelsiusScale::getInternalID()),
                        FahrenheitScale::getInternalID()
                    );
            }
            foreach ($temperature['prediction'] as $item){
                $completeTemperatures[$item['time']][] = $item['value'];
            }
        }

        foreach ($completeTemperatures as $time => $values){
            $averageTemperatures[] = [
                'time' => $time,
                'value' => round(array_sum($values) / count($values), 1)
            ];
        }

        return $averageTemperatures;
    }

}