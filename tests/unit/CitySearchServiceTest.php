<?php

namespace App\Tests\Services;

use App\Repository\CityRepository;
use App\Services\CitySearchService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Exception\InvalidParameterException;

class CitySearchServiceTest extends TestCase
{
    public function testHavingAQueryWithLessCharactersThanMinimumExpectedThenInvalidParameterExceptionShouldBeThrown(): void
    {
        // Setup
        $cityRepositoryMock = $this->createMock(CityRepository::class);
        $service = new CitySearchService($cityRepositoryMock);
        $query = 'ze';

        // Assert
        $this->expectException(InvalidParameterException::class);
        $this->expectExceptionCode(400);
        $this->expectExceptionMessage('Query must have at least 3 characters');

        // Act
        $service->__invoke($query);
    }

    public function testHavingAQueryWithExpectedCharactersCountThenRepositoryFindByQueryMethodShouldBeCalled(): void
    {
        // Setup
        $cityRepositoryMock = $this->createMock(CityRepository::class);
        $service = new CitySearchService($cityRepositoryMock);
        $query = 'zei';

        // Assert
        $cityRepositoryMock
            ->expects(self::once())
            ->method('findByQuery')
            ->with($query);

        // Act
        $service->__invoke($query);
    }
}
