<?php

namespace App\Controller;


use App\Services\TemperaturePredictionService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Exception\InvalidParameterException;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class TemperaturePredictionController
{
    /** @var TemperaturePredictionService */
    private $temperaturePredictionService;

    /**
     * @param TemperaturePredictionService $temperaturePredictionService
     */
    public function __construct(TemperaturePredictionService $temperaturePredictionService)
    {
        $this->temperaturePredictionService = $temperaturePredictionService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        try{
            $response = $this->temperaturePredictionService->__invoke($request);
            return new JsonResponse([
                'success' => true,
                'city' => $response->getCity(),
                'scale' => $response->getScale(),
                'date' => $response->getDate(),
                'predictions' => $response->getTemperatures()
            ], 200);
        } catch (InvalidParameterException|ResourceNotFoundException $e){
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], $e->getCode());
        }
    }

}