<?php

namespace App\Services;

use App\Entity\City;
use App\Entity\Prediction;
use App\Model\PredictionRequest;
use App\Model\PredictionResponse;
use App\Repository\CityRepository;
use App\Services\Scales\CelsiusScale;
use App\Services\Scales\ScaleFactory;
use App\Services\Scales\ScaleInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class TemperaturePredictionService
{
    private const MAX_DAYS_FROM_TODAY = 10;

    /** @var CityRepository */
    private $cityRepository;

    /** @var RetrievePredictionService */
    private $retrievePredictionService;

    /**
     * @param CityRepository $cityRepository
     * @param RetrievePredictionService $retrievePredictionService
     */
    public function __construct(CityRepository $cityRepository, RetrievePredictionService $retrievePredictionService)
    {
        $this->cityRepository = $cityRepository;
        $this->retrievePredictionService = $retrievePredictionService;
    }

    /**
     * @param Request $request
     * @return PredictionResponse
     */
    public function __invoke(Request $request): PredictionResponse
    {
        return $this->retrievePredictionService->__invoke($this->createRequestModel($request));
    }

    private function createRequestModel(Request $request): PredictionRequest
    {
        if (!$request->get('city')){
            throw new InvalidParameterException('Check required parameter: city', 400);
        }
        if( ($city = $this->cityRepository->find($request->get('city'))) instanceof City === false){
            throw new ResourceNotFoundException('City not found ', 404);
        }

        if (!$request->get('scale')){
            $request->request->set('scale', CelsiusScale::getInternalID());
        }
        if( ($scale = ScaleFactory::make($request->get('scale'))) instanceof ScaleInterface === false){
            throw new ResourceNotFoundException('Scale not found ', 404);
        }

        $now = new \DateTime();
        if (!$request->get('date')){
            $request->request->set('date', $now->format(Prediction::EXPECTED_DATE_FORMAT)); // Today
        }
        $date = \DateTime::createFromFormat(Prediction::EXPECTED_DATE_FORMAT, $request->get('date'));
        if($date instanceof \DateTime === false){
            throw new InvalidParameterException(sprintf('Date format not expected: %s', Prediction::EXPECTED_DATE_FORMAT), 400);
        }
        if($date->format(Prediction::EXPECTED_DATE_FORMAT) < $now->format(Prediction::EXPECTED_DATE_FORMAT)){
            throw new InvalidParameterException('Date could not be past', 400);
        }
        $maxDate = \DateTime::createFromFormat(Prediction::EXPECTED_DATE_FORMAT, $now->modify(sprintf('+ %s day', self::MAX_DAYS_FROM_TODAY))->format(Prediction::EXPECTED_DATE_FORMAT));
        if($date > $maxDate){
            throw new InvalidParameterException(sprintf('Date could not be greater than %s days from today', self::MAX_DAYS_FROM_TODAY), 400);
        }

        $predictionRequest = new PredictionRequest();
        $predictionRequest->setCity($city);
        $predictionRequest->setScale($scale);
        $predictionRequest->setDate($date);
        return $predictionRequest;
    }

}