<?php

namespace App\Model;

use App\Entity\City;
use App\Entity\Scale;

class PredictionResponse
{
    /** @var string */
    private $city;

    /** @var string */
    private $scale;

    /** @var string */
    private $date;

    /** @var array */
    private $temperatures;

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): void
    {
        $this->city = $city;
    }

    /**
     * @return string
     */
    public function getScale(): string
    {
        return $this->scale;
    }

    /**
     * @param string $scale
     */
    public function setScale(string $scale): void
    {
        $this->scale = $scale;
    }

    /**
     * @return string
     */
    public function getDate(): string
    {
        return $this->date;
    }

    /**
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @return array
     */
    public function getTemperatures(): array
    {
        return $this->temperatures;
    }

    /**
     * @param array $temperatures
     */
    public function setTemperatures(array $temperatures): void
    {
        $this->temperatures = $temperatures;
    }
}