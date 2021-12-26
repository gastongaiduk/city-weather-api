<?php

namespace App\Services;

use App\Repository\CityRepository;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class CitySearchService
{
    /** @var CityRepository */
    private $cityRepository;

    /**
     * @param CityRepository $cityRepository
     */
    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    /**
     * @param string $query
     * @return array
     */
    public function __invoke(string $query): array
    {
        if(strlen($query) < 3){
            throw new InvalidParameterException('Query must have at least 3 characters', 400);
        }

        return $this->cityRepository->findByQuery($query);
    }

}