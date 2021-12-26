<?php

namespace App\Controller;

use App\Services\CitySearchService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class CitySearchController
{
    /** @var CitySearchService */
    private $citySearchService;

    /**
     * @param CitySearchService $citySearchService
     */
    public function __construct(CitySearchService $citySearchService)
    {
        $this->citySearchService = $citySearchService;
    }

    public function __invoke(string $query): JsonResponse
    {
        try{
            return new JsonResponse([
                'success' => true,
                'results' => $this->citySearchService->__invoke($query)
            ], 200);
        } catch (InvalidParameterException $e){
            return new JsonResponse(['success' => false, 'error' => $e->getMessage()], $e->getCode());
        }
    }

}