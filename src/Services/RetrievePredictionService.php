<?php

namespace App\Services;

use App\Entity\Prediction;
use App\Model\PredictionRequest;
use App\Model\PredictionResponse;
use App\Repository\PredictionRepository;
use App\Services\Scales\CelsiusScale;
use App\Services\Scales\ScaleInterface;

class RetrievePredictionService
{
    /** @var PredictionRepository */
    private $predictionRepository;

    /** @var UpdatePredictionService */
    private $updatePredictionService;

    /** @var ScaleConverterService */
    private $converterService;

    /**
     * @param PredictionRepository $predictionRepository
     * @param UpdatePredictionService $updatePredictionService
     * @param ScaleConverterService $converterService
     */
    public function __construct(PredictionRepository $predictionRepository, UpdatePredictionService $updatePredictionService, ScaleConverterService $converterService)
    {
        $this->predictionRepository = $predictionRepository;
        $this->updatePredictionService = $updatePredictionService;
        $this->converterService = $converterService;
    }

    /**
     * @param PredictionRequest $request
     * @return PredictionResponse
     */
    public function __invoke(PredictionRequest $request): PredictionResponse
    {
        $prediction = $this->buildPredictionFromRequest($request);

        if(!$prediction->isValid()){
            $this->updatePredictionService->__invoke($prediction);
        }

        return $this->buildPredictionResponse($prediction, $request->getScale());
    }

    private function buildPredictionFromRequest(PredictionRequest $request): Prediction
    {
        $prediction = $this->predictionRepository->findOneBy([
            'city' => $request->getCity(),
            'date' => $request->getDate()
        ]);

        if($prediction instanceof Prediction === false){
            $prediction = new Prediction();
            $prediction->setCity($request->getCity());
            $prediction->setDate($request->getDate());
        }

        return $prediction;
    }

    private function buildPredictionResponse(Prediction $prediction, ScaleInterface $scale): PredictionResponse
    {
        $response = new PredictionResponse();
        $response->setCity($prediction->getCity()->getName());
        $response->setScale($scale->getName());
        $response->setDate($prediction->getDate()->format(Prediction::EXPECTED_DATE_FORMAT));
        $celsiusTemperatures = $prediction->getTemperatures();
        $response->setTemperatures($this->converterService->__invoke($celsiusTemperatures, $scale, CelsiusScale::getInternalID()));
        return $response;
    }

}