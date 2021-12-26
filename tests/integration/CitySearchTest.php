<?php

namespace App\Tests\integration;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CitySearchTest extends WebTestCase
{
    private const ENDPOINT = 'http://localhost:8000';

    protected function setUp(): void
    {
        $this->client = new Client([
            'base_uri' => self::ENDPOINT
        ]);
    }

    /**
     * @throws GuzzleException
     */
    public function testCitySearchExistingCityShouldReturnResults(): void
    {
        $query = 'amsterdam';

        $request = new Request(
            'GET',
            self::ENDPOINT . '/city_search/'.$query
        );

        $response = $this->client->send($request);

        self::assertEquals(200, $response->getStatusCode());
        self::assertJson($response->getBody());
        $dataResponse = json_decode($response->getBody(), true);
        self::assertArrayHasKey('success', $dataResponse);
        self::assertTrue($dataResponse['success']);
        self::assertArrayHasKey('results', $dataResponse);
        self::assertNotEmpty($dataResponse['results']);
    }

}